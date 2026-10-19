<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex gap-3 align-items-center">
            <i class="bi bi-postcard fs-4 text-warning"></i>
            <div class="d-flex align-items-center gap-2">
                <h2 class="fs-4 text-primary mb-0">POS Lite</h2>
                <span class="badge bg-light text-primary border border-primary rounded-pill px-2 fs-8"
                    style="font-size: 0.75rem;">
                    v<?= $version ?? '1.0.0' ?>
                </span>
            </div>
        </div>


        <div class="d-flex gap-3 align-items-center">
            <a href="<?= site_url('/pos') ?>"
                class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-cart-fill me-2"></i>POS
            </a>

            <div class="dropdown">
                <button class="btn btn-light rounded-circle p-2"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-circle fs-5"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 py-2">
                    <li class="px-3 py-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-circle fs-6"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <p class="fw-bold mb-0"><?= $user['username'] ?? 'User' ?></p>
                                <small class="text-muted"><?= $user['email'] ?? 'email@example.com' ?></small>
                            </div>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="<?= site_url('profile') ?>">
                            <i class="bi bi-person me-2"></i>View Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-2" href="<?= site_url('profile/edit') ?>">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </a>
                    </li>
                    <?php if ('role_id' === 1): ?>
                        <li>
                            <a class="dropdown-item py-2" href="<?= site_url('users/create') ?>">
                                <i class="bi bi-person-plus me-2"></i>Add User
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item py-2 text-danger" href="<?= site_url('/user-logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5 JS Bundle (Popper.js included) -->
</nav>