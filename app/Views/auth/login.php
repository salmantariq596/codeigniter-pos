<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .login-container {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
        }

        .login-form {
            max-width: 450px;
            margin: 0 auto;
        }

        .input-group-text {
            border: none;
            border-right: 1px solid #dee2e6;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

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

<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="login-container">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">POS Lite</h2>
                        <p class="text-muted">Please sign in to continue</p>
                    </div>

                    <div class="login-form">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="/user-login" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-envelope-fill text-primary"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="mb-4">
                                    <div class="mb-4">
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

                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label class="form-check-label" for="remember">Remember me</label>
                                        </div>
                                        <a href="/forgot-password" class="text-primary text-decoration-none">Forgot Password?</a>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary py-2">Sign In</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

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

</html>