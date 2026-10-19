<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\MenuItemModel;
use App\Models\RolePermissionModel;
use App\Models\UserModel;
use App\Models\PermissionModel;
use App\Models\AppVersion;

abstract class BaseController extends Controller
{
    protected $request;
    protected $userModel;
    protected $versionModel;
    protected $viewData = [];

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->userModel = new UserModel();
        $this->versionModel = new AppVersion();

        // Initialize session data
        $session = session();
        $userSession = $session->get('user');
        
        // Store user data if logged in
        if ($userSession && isset($userSession['id'])) {
            $this->viewData['user'] = $this->userModel->find($userSession['id']);
        }

        // Always include version number
        $this->viewData['version'] = $this->versionModel->getCurrentVersion();
    }

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Menu initialization logic remains
        $userPermissions = $this->getUserPermissions();
        $menuModel = new MenuItemModel();
        $menuData = $menuModel->getAllMenuData();
        $filteredMenuData = $this->filterMenuDataByPermissions($menuData, $userPermissions);
        $this->viewData['menuData'] = $filteredMenuData;
    }

    public function filterMenuDataByPermissions($menuData, $userPermissions)
    {
        $filteredMenuData = [];

        foreach ($menuData as $section) {
            if (in_array($section['slug'], $userPermissions)) {
                $filteredMenuData[] = $section;
            } else {
                $filteredItems = array_filter($section['items'], function ($item) use ($userPermissions) {
                    return !empty($item['slug']) && in_array($item['slug'], $userPermissions);
                });

                if (!empty($filteredItems)) {
                    $sectionCopy = $section;
                    $sectionCopy['items'] = $filteredItems;
                    $filteredMenuData[] = $sectionCopy;
                }
            }
        }

        return $filteredMenuData;
    }


    protected function getUserPermissions(): array
    {
        $session = session();
        $user = $session->get('user');

        if (!$user) {
            return [];
        }

        $userModel = new UserModel();
        $userDetails = $userModel->find($user['id']);

        // If user is a superadmin
        if ($userDetails && $userDetails['username'] == 'admin') {
            $permissionModel = new PermissionModel();
            $allPermissions = $permissionModel->findAll();
            return array_column($allPermissions, 'slug');
        }

        // Retrieve user permissions for non-superadmin users
        $rolePermissionModel = new RolePermissionModel();
        $permissions = $rolePermissionModel
            ->select('permissions.slug')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', $user['role_id'])
            ->findAll();

        return array_column($permissions ?? [], 'slug');
    }

    protected function render($view, $data = [])
    {
        $data = array_merge($this->viewData, $data);
        return view($view, $data);
    }
}
