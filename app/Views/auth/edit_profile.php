<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h4 class="mb-4">Edit Profile</h4>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('profile/edit') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text"
                                class="form-control <?= validation_show_error('username') ? 'is-invalid' : '' ?>"
                                name="username"
                                value="<?= old('username', $user['username']) ?>">
                            <div class="invalid-feedback">
                                <?= validation_show_error('username') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                class="form-control <?= validation_show_error('email') ? 'is-invalid' : '' ?>"
                                name="email"
                                value="<?= old('email', $user['email']) ?>">
                            <div class="invalid-feedback">
                                <?= validation_show_error('email') ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('profile') ?>"
                                class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>