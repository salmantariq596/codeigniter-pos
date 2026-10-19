<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>Edit Purchase</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Edit Purchase</h1>

        <form action="<?= base_url('purchases/updatePurchase/' . $purchase['id']) ?>" method="post">
            <!-- Vendor Selection -->
            <div class="mb-3">
                <label for="vendor_id" class="form-label">Vendor</label>
                <select name="vendor_id" id="vendor_id" class="form-select">
                    <?php foreach ($vendors as $vendor): ?>
                        <option value="<?= $vendor['id'] ?>" <?= $purchase['vendor_id'] == $vendor['id'] ? 'selected' : '' ?>>
                            <?= $vendor['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Product Details -->
            <div id="product-container">
                <?php foreach ($purchase_details as $key => $detail): ?>
                    <div class="row g-3 align-items-center mb-3 product-row">
                        <!-- Product Selection -->
                        <div class="col-md-4">
                            <label for="product_<?= $key ?>" class="form-label">Product</label>
                            <select name="products[<?= $key ?>][product_id]" id="product_<?= $key ?>" class="form-select">
                                <?php foreach ($products as $product): ?>
                                    <option value="<?= $product['id'] ?>" <?= $detail['product_id'] == $product['id'] ? 'selected' : '' ?>>
                                        <?= $product['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Quantity Input -->
                        <div class="col-md-3">
                            <label for="quantity_<?= $key ?>" class="form-label">Quantity</label>
                            <input type="number" id="quantity_<?= $key ?>" name="products[<?= $key ?>][quantity]" value="<?= $detail['quantity'] ?>" class="form-control" placeholder="Quantity" required>
                        </div>
                        <!-- Price Input -->
                        <div class="col-md-3">
                            <label for="price_<?= $key ?>" class="form-label">Price</label>
                            <input type="text" id="price_<?= $key ?>" name="products[<?= $key ?>][price]" value="<?= $detail['price'] ?>" class="form-control" placeholder="Price" required>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Purchase
                </button>
            </div>
        </form>
    </div>

    <?= $this->endSection() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>