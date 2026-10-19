<?= $this->extend('layout/layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Edit Stock Adjustment</h1>
    <form action="/inventory/updateAdjustment/<?= $adjustment['id']; ?>" method="post" class="needs-validation" novalidate>
        <?= csrf_field(); ?>
        
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-select" disabled>
                <?php foreach ($products as $product): ?>
                <option value="<?= $product['id']; ?>" <?= $adjustment['product_id'] == $product['id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($product['name']); ?>
                </option>
                <?php endforeach; ?>
            </select>
            <div class="form-text">The product cannot be changed.</div>
        </div>

        <div class="mb-3">
            <label for="adjustment_type" class="form-label">Adjustment Type</label>
            <select name="adjustment_type" id="adjustment_type" class="form-select">
                <option value="add" <?= $adjustment['adjustment_type'] == 'add' ? 'selected' : ''; ?>>Add</option>
                <option value="remove" <?= $adjustment['adjustment_type'] == 'remove' ? 'selected' : ''; ?>>Remove</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $adjustment['quantity']; ?>" required>
            <div class="invalid-feedback">
                Please provide a valid quantity.
            </div>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <input type="text" name="reason" id="reason" class="form-control" value="<?= htmlspecialchars($adjustment['reason']); ?>">
            <div class="form-text">Specify a reason for the adjustment (optional).</div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update Adjustment</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
