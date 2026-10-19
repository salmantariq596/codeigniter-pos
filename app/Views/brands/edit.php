<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>Edit Brand</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container my-5">
        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="fw-bold text-primary">Edit Brand</h1>
        </div>

        <!-- Edit Brand Form -->
        <div class="card shadow">
            <div class="card-body">
                <form action="/brands/update/<?= $brand['id'] ?>" method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?= $brand['name'] ?>" required>
                        <div class="invalid-feedback">Please provide a valid brand name.</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="/brands" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Form Validation Script -->
    <script>
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>

</html>
