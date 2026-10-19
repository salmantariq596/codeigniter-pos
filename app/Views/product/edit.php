<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>Edit Product</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3>Edit Product</h3>
            </div>
            <div class="card-body">
                <!-- Display validation errors (if any) -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="/product/update/<?= $product['id']; ?>" method="post" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $product['name']; ?>" required>
                    </div>

                     <!-- Brand Name -->
                     <div class="mb-3">
                        <label for="brand" class="form-label">Brand</label>
                        <input type="text" name="brand" id="brand" class="form-control" value="<?= $product['brand']; ?>" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id']; ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                    <?= $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" name="price" id="price" class="form-control" value="<?= $product['price']; ?>" required>
                    </div>

                    <!-- Barcode -->
                    <div class="mb-3">
                        <label for="product_barcode" class="form-label">Product Barcode</label>
                        <input type="text" name="product_barcode" id="product_barcode" class="form-control" value="<?= $product['product_barcode']; ?>" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control" required><?= $product['description']; ?></textarea>
                    </div>

                    <!-- Available Stock -->
                    <div class="mb-3">
                        <label for="available_stock" class="form-label">Available Stock</label>
                        <input type="number" name="available_stock" id="available_stock" class="form-control" value="<?= $product['available_stock']; ?>" required>
                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="img" class="form-label">Product Image</label>
                        <input type="file" name="img" id="img" class="form-control">
                        <div class="form-text">Leave empty to keep the current image.</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
