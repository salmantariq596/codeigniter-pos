<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>All Brands</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container my-5">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-primary">Brands</h1>
            <a href="/brands/create" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Brand
            </a>
        </div>

        <!-- Brands Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brands as $brand): ?>
                        <tr>
                            <td class=""><?= $brand['id'] ?></td>
                            <td><?= $brand['name'] ?></td>
                            <td class="text-center">
                                <a href="/brands/edit/<?= $brand['id'] ?>" class="btn btn-sm btn-warning me-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="/brands/delete/<?= $brand['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this brand?')">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->endSection() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
