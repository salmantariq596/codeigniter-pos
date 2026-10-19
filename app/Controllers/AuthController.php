<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\RoleModel;
use Config\Services;

class AuthController extends BaseController
{
    protected $validation;

    public function __construct()
    {
        parent::__construct();
        $this->validation = Services::validation();
    }

    protected function validateRequest(array $rules): bool
    {
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return false;
        }
        return true;
    }

    protected function validateCredentials(string $email, string $password): ?array
    {
        $user = $this->userModel->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    public function login()
    {
        if (session()->get('user')) {
            return redirect()->to('/dashboard-new');
        }
        return $this->render('auth/login');
    }

    public function authenticate()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validateRequest($rules)) {
            return redirect()->back()->withInput();
        }

        $user = $this->validateCredentials(
            $this->request->getPost('email'),
            $this->request->getPost('password')
        );

        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid credentials');
        }

        session()->set('user', $user);
        return redirect()->to('/dashboard-new');
    }

    public function register()
    {
        $roleModel = new RoleModel(); // You'll need to create this model
        $roles = $roleModel->findAll();
        return $this->render('auth/register', [
            'validation' => $this->validation,
            'roles' => $roles,
        ]);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required'
        ];

        if (!$this->validateRequest($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role_id' => $this->request->getPost('role'), // Insert role_id based on role name
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->userModel->insert($userData);

            return redirect()
                ->to('/roles-permissions')
                ->with('success', 'User registered successfully!');
        } catch (\Exception $e) {
            log_message('error', 'User registration failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to register user. Please try again.');
        }
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user-login');
    }

    public function fetchUsersOld()
    {
        $users = $this->userModel->findAll();

        $formattedUsers = array_map(function ($user) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'created_at' => date('Y-m-d H:i:s', strtotime($user['created_at'])),
                'updated_at' => date('Y-m-d H:i:s', strtotime($user['updated_at']))
            ];
        }, $users);

        return $this->response->setJSON(['data' => $formattedUsers]);
    }

    public function fetchUsers()
    {
        // Get DataTables parameters from the request
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';

        // Initialize the query
        $query = $this->userModel;

        // Apply search filter
        if (!empty($searchValue)) {
            $query->like('username', $searchValue)
                ->orLike('email', $searchValue);
        }

        // Count total records
        $totalRecords = $this->userModel->countAll();

        // Count records after filtering
        $filteredRecords = $query->countAllResults(false);

        // Get paginated and filtered results
        $users = $query->orderBy('created_at', 'DESC')
            ->findAll($length, $start);

        // Format user data
        $formattedUsers = array_map(function ($user) {
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'created_at' => date('Y-m-d H:i:s', strtotime($user['created_at'])),
                'updated_at' => date('Y-m-d H:i:s', strtotime($user['updated_at']))
            ];
        }, $users);

        // Return the response
        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $formattedUsers
        ]);
    }


    public function listUsers()
    {
        return $this->render('users/user_list');
    }

    public function profile()
    {
        $userId = session()->get('user')['id'];
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/user-login')
                ->with('error', 'User not found');
        }

        return $this->render('auth/user_profile', ['user' => $user]);
    }

    public function editProfile()
    {

        helper(['form']);
        $userId = session()->get('user')['id'];
        $user = $this->userModel->find($userId);

        if (!$user) {
            log_message('error', 'User not found with ID: ' . $userId);
            return redirect()->to('/user-login')
                ->with('error', 'User not found');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|min_length[3]',
                'email' => "required|valid_email|is_unique[users.email,id,{$userId}]"
            ];

            // Log the received POST data
            log_message('debug', 'Received POST data: ' . json_encode($this->request->getPost()));

            if (!$this->validate($rules)) {
                log_message('error', 'Validation errors: ' . json_encode($this->validator->getErrors()));
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Please check the form for errors');
            }


            $updateData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            try {
                $updated = $this->userModel->update($userId, $updateData);

                if ($updated) {
                    log_message('info', 'Profile updated successfully for user ID: ' . $userId);

                    // Refresh user data in session
                    $updatedUser = $this->userModel->find($userId);
                    session()->set('user', $updatedUser);

                    return redirect()->to('/profile')
                        ->with('success', 'Profile updated successfully');
                } else {
                    log_message('error', 'Failed to update profile. User Model errors: ' . json_encode($this->userModel->errors()));
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to update profile');
                }
            } catch (\Exception $e) {

                log_message('error', 'Exception during profile update: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'An error occurred while updating profile');
            }
        }

        return $this->render('auth/edit_profile', [
            'user' => $user,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function changePassword()
    {
        $userId = session()->get('user')['id'];
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/user-login')
                ->with('error', 'User not found');
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/profile')
                ->with('error', 'Password validation failed');
        }

        if (!password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->to('/profile')
                ->with('error', 'Current password is incorrect');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/profile')
            ->with('success', 'Password changed successfully');
    }
}
