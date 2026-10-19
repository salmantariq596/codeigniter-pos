<?php

namespace App\Controllers\Admin;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\PermissionModel;
use App\Models\RolePermissionModel;
use App\Controllers\BaseController;

class RolesPermissionsController extends BaseController
{
    public function index()
    {
        $roleModel = new RoleModel();
        $userModel = new UserModel();
        $permissionModel = new PermissionModel();
        $rolePermissionModel = new RolePermissionModel();

        $data = [
            'roles' => $roleModel->findAll(),
            'users' => $userModel->select('users.*, roles.name as role_name')
                ->join('roles', 'users.role_id = roles.id', 'left')
                ->findAll(),
            'permissions' => $permissionModel->findAll(),
            'rolePermissions' => $rolePermissionModel->findAll(),
        ];

        // Get permissions for each role
        foreach ($data['roles'] as &$role) {
            $role['permissions'] = $rolePermissionModel->where('role_id', $role['id'])
                ->join('permissions', 'permissions.id = role_permissions.permission_id')
                ->findAll();
        }

        return $this->render('auth/roles_permissions', $data);
    }

    public function storeRole()
    {
        $roleModel = new RoleModel();
        $roleModel->save($this->request->getPost());
        return redirect()->to('/roles-permissions')->with('success', 'Role created successfully.');
    }

    public function storePermission()
    {
        $permissionModel = new PermissionModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'slug' => strtolower(str_replace(' ', '-', $this->request->getPost('name')))
        ];
        $permissionModel->save($data);
        return redirect()->to('/roles-permissions')->with('success', 'Permission created successfully.');
    }

    public function assignUserRole()
    {
        $userId = $this->request->getPost('user_id');
        $roleId = $this->request->getPost('role_id');

        if (empty($userId) || empty($roleId)) {
            return redirect()->back()->with('error', 'User ID and Role ID are required.');
        }

        $userModel = new UserModel();
        $updateData = ['role_id' => $roleId];
        
        $userModel->update($userId, $updateData);
        return redirect()->to('/roles-permissions')->with('success', 'User role updated successfully.');
    }

    public function assignRolePermissions()
    {
        $roleId = $this->request->getPost('role_id');
        $permissions = $this->request->getPost('permissions') ?? [];
        
        $rolePermissionModel = new RolePermissionModel();
        
        // Delete existing permissions for this role
        $rolePermissionModel->where('role_id', $roleId)->delete();
        
        // Assign new permissions
        foreach ($permissions as $permissionId) {
            $rolePermissionModel->insert([
                'role_id' => $roleId,
                'permission_id' => $permissionId
            ]);
        }
        
        return redirect()->to('/roles-permissions')->with('success', 'Role permissions updated successfully.');
    }

    public function deleteRole($id)
    {
        $roleModel = new RoleModel();
        $roleModel->delete($id);
        return redirect()->to('/roles-permissions')->with('success', 'Role deleted successfully.');
    }

    public function deletePermission($id)
    {
        $permissionModel = new PermissionModel();
        $permissionModel->delete($id);
        return redirect()->to('/roles-permissions')->with('success', 'Permission deleted successfully.');
    }
}