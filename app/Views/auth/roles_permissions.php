<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
<div class="bg-light py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 mb-3">
                <h1 class="h3 text-primary mb-0">User Access Management</h1>
                <p class="text-muted mb-0">Manage roles and permissions for your users</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="row g-3 mb-4">
        <div class="col-sm-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                        <div class="ms-3">
                            <div class="fs-4 fw-bold"><?= count($users) ?></div>
                            <div class="text-muted">Active Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-shield text-success"></i>
                        </div>
                        <div class="ms-3">
                            <div class="fs-4 fw-bold"><?= count($roles) ?></div>
                            <div class="text-muted">User Roles</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-key text-info"></i>
                        </div>
                        <div class="ms-3">
                            <div class="fs-4 fw-bold"><?= count($permissions) ?></div>
                            <div class="text-muted">Permissions</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Users List -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Role Assignment</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">User</th>
                                    <th>Current Role</th>
                                    <th class="pe-3">Change Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td class="ps-3"><?= esc($user['username']) ?></td>
                                        <td>
                                            <?php if (isset($user['role_name'])): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success"><?= esc($user['role_name']) ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary">No Role</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="pe-3">
                                            <form action="/roles/assignUserRole" method="POST" class="d-flex gap-2">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <select name="role_id" class="form-select form-select-sm" style="max-width: 200px">
                                                    <option value="">Select Role...</option>
                                                    <?php foreach ($roles as $role): ?>
                                                        <option value="<?= $role['id'] ?>" <?= ($user['role_id'] ?? '') == $role['id'] ? 'selected' : '' ?>>
                                                            <?= esc($role['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary px-3">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles Management -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Roles & Permissions</h5>
                        <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="fas fa-plus me-2"></i>New Role
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="rolesAccordion">
                        <?php foreach ($roles as $role): ?>
                            <div class="accordion-item border-0 border-bottom">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed px-3" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#role<?= $role['id'] ?>">
                                        <span class="fw-medium"><?= esc($role['name']) ?></span>
                                    </button>
                                </h2>
                                <div id="role<?= $role['id'] ?>" class="accordion-collapse collapse"
                                    data-bs-parent="#rolesAccordion">
                                    <div class="accordion-body">
                                        <form action="/roles/permissions" method="POST">
                                            <input type="hidden" name="role_id" value="<?= $role['id'] ?>">
                                            <div class="mb-3">
                                                <div class="row g-3">
                                                    <?php foreach ($permissions as $permission): ?>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="permissions[]"
                                                                    value="<?= $permission['id'] ?>"
                                                                    <?= isset($role['permissions']) && in_array($permission['id'], array_column($role['permissions'], 'permission_id')) ? 'checked' : '' ?>>
                                                                <label class="form-check-label">
                                                                    <?= esc($permission['name']) ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>

                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <button type="submit" class="btn btn-primary btn-sm px-3">Update Permissions</button>
                                                <button type="button" class="btn btn-danger btn-sm px-3"
                                                    onclick="confirmDelete(<?= $role['id'] ?>)">
                                                    <i class="fas fa-trash me-2"></i>Delete Role
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions List -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Permissions</h5>
                        <button class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#createPermissionModal">
                            <i class="fas fa-plus me-2"></i>New Permission
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Permission</th>
                                    <th class="pe-3 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($permissions as $permission): ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div><?= esc($permission['name']) ?></div>
                                            <small class="text-muted"><?= esc($permission['slug']) ?></small>
                                        </td>
                                        <td class="pe-3 text-end">
                                            <button class="btn btn-sm btn-danger"
                                                onclick="confirmDeletePermission(<?= $permission['id'] ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/roles/store">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Role Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Permission Modal -->
<div class="modal fade" id="createPermissionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Create New Permission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/permissions/store">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Permission Name</label>
                        <input type="text" class="form-control" name="name" required
                            placeholder="e.g., Create Users">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required
                            placeholder="Describe what this permission allows"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all tooltips
        var tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltips.map(function(tooltip) {
            return new bootstrap.Tooltip(tooltip)
        });

        // Auto-hide flash messages
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                bootstrap.Alert.getOrCreateInstance(alert).close();
            });
        }, 3000);

        // Fix for accordion toggle
        var accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var target = this.getAttribute('data-bs-target');
                var content = document.querySelector(target);

                if (content.classList.contains('show')) {
                    content.classList.remove('show');
                    this.classList.add('collapsed');
                } else {
                    // Close other open accordions
                    document.querySelectorAll('.accordion-collapse.show').forEach(function(item) {
                        if (item !== content) {
                            item.classList.remove('show');
                            item.previousElementSibling.querySelector('.accordion-button').classList.add('collapsed');
                        }
                    });

                    content.classList.add('show');
                    this.classList.remove('collapsed');
                }
            });
        });
    });

    function confirmDelete(roleId) {
        if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
            window.location.href = `/roles/delete/${roleId}`;
        }
    }

    function confirmDeletePermission(permissionId) {
        if (confirm('Are you sure you want to delete this permission? This action cannot be undone and may affect existing roles.')) {
            window.location.href = `/permissions/delete/${permissionId}`;
        }
    }
    <?= $this->endSection() ?>