<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>

<style>
    /* Add eye icon styling */

    .password-toggle-container {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 5;
        color: #6c757d;
        background: transparent;
        border: none;
        padding: 0;
    }
</style>
<!-- Main content -->
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Register New User</h1>
            </div>

            <!-- Registration Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="/user-register" method="post" class="row g-4">
                        <?= csrf_field() ?>

                        <!-- Role Selection -->
                        <div class="col-md-6">
                            <label class="form-label">User Role</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-shield-lock text-primary"></i>
                                </span>
                                <select name="role" class="form-select" required>
                                    <option value="" selected disabled>Select user role</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?= $role['id'] ?>">
                                            <?= htmlspecialchars($role['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-person text-primary"></i>
                                </span>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope text-primary"></i>
                                </span>
                                <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <div class="input-group password-toggle-container">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock-fill text-primary"></i>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="form-control"
                                    placeholder="Enter your password"
                                    required>
                                <span class="password-toggle" onclick="togglePassword()">
                                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button type="submit" href="/datatable/user_list" class="btn btn-primary px-4">
                                <i class="bi bi-person-plus me-2"></i>Create User
                            </button>
                            <a href="/datatable/user_list" class="btn btn-light px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            passwordField.type = 'password';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    }
</script>

<?= $this->endSection() ?>