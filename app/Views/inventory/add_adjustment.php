<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Add Stock Adjustment</h1>

    <form action="/inventory/adjustStock" method="post">
        <?= csrf_field(); ?>
        
        <div class="form-group mb-3">
            <label for="product_id">Product</label>
            <select name="product_id" class="form-control" required>
                <?php foreach ($products as $product): ?>
                <option value="<?= $product['id']; ?>"><?= htmlspecialchars($product['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="adjustment_type">Adjustment Type</label>
            <select name="adjustment_type" class="form-control" required>
                <option value="add">Add</option>
                <option value="remove">Remove</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="reason">Reason</label>
            <input type="text" name="reason" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Adjustment</button>
    </form>
</div>

<?= $this->endSection() ?>
