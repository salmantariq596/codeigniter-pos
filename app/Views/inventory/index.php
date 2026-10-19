<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Inventory Management</h1>

    <!-- Products Section -->
    <h2 class="mb-3">Products</h2>
    <table class="table table-bordered table-hover">
        <thead class="">
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Available Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product['id']; ?></td>
                <td><?= htmlspecialchars($product['name']); ?></td>
                <td><?= $product['available_stock']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Stock Adjustments Section -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-3">
        <h2>Stock Adjustments</h2>
        <a href="/inventory/addAdjustment" class="btn btn-primary">Add Adjustment</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="">
            <tr>
                <th>ID</th>
                <th>Product</th>
                <!-- <th>Type</th> -->
                <th>Quantity</th>
                <th>Reason</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adjustments as $adjustment): ?>
            <tr>
                <td><?= $adjustment['id']; ?></td>
                <td><?= htmlspecialchars($adjustment['product_name']); ?></td>
                <td><?= $adjustment['quantity']; ?></td>
                <td><?= htmlspecialchars($adjustment['reason']); ?></td>
                <td><?= $adjustment['adjusted_at']; ?></td>
                <td>
                    <a href="/inventory/editAdjustment/<?= $adjustment['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="/inventory/deleteAdjustment/<?= $adjustment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
