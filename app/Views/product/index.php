<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>All Products</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>All Products</h3>
            <a href="<?= site_url('product/add') ?>" class="btn btn-success">+ Add Product</a>
        </div>

        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Barcode</th>
                        <th>Unit</th>
                        <th>Description</th>
                        <th>Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= esc($product['id']) ?></td>
                            <td class="text-center">
                                <?php if (!empty($product['img'])): ?>
                                    <img src="<?= base_url('uploads/' . $product['img']) ?>" alt="<?= esc($product['name']) ?>" class="img-thumbnail" style="width: 50px; height: 50px;">
                                <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($product['name']) ?></td>
                            <td><?= esc($product['brand']) ?></td>
                            <td><?= esc($product['category_name']) ?></td>
                            <td><?= number_format($product['price'], 2) ?></td>
                            <td><?= esc($product['product_barcode']) ?></td>
                            <td><?= esc($product['product_unit']) ?></td>
                            <td><?= esc($product['description']) ?></td>
                            <td><?= esc($product['available_stock']) ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('product/edit/' . $product['id']) ?>" class="btn btn-warning btn-sm me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="<?= site_url('product/delete/' . $product['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?= $this->endSection() ?>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
</body>

</html>
