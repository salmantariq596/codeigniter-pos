// File: app/Views/auth/user_profile.php
<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle p-3 d-inline-block mb-3">
                            <i class="bi bi-person-circle display-4 text-primary"></i>
                        </div>
                        <h4 class="mb-1"><?= esc($user['username']) ?></h4>
                        <p class="text-muted"><?= esc($user['email']) ?></p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-4">
                                <h6 class="mb-3">Account Information</h6>
                                <div class="mb-3">
                                    <label class="text-muted small">Username</label>
                                    <p class="mb-0"><?= esc($user['username']) ?></p>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted small">Email</label>
                                    <p class="mb-0"><?= esc($user['email']) ?></p>
                                </div>
                                <div>
                                    <label class="text-muted small">Member Since</label>
                                    <p class="mb-0"><?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-4 h-100">
                                <h6 class="mb-3">Quick Actions</h6>
                                <div class="d-grid gap-2">
                                    <a href="<?= site_url('profile/edit') ?>" 
                                       class="btn btn-outline-primary">
                                        <i class="bi bi-pencil me-2"></i>Edit Profile
                                    </a>
                                    <button class="btn btn-outline-secondary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#changePasswordModal">
                                        <i class="bi bi-key me-2"></i>Change Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('profile/change-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>