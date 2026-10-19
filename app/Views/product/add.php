<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>Add Product</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>

    <?= $this->section('content') ?>

    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3>Add Product</h3>
            </div>
            <div class="card-body">
                <form action="<?= site_url('product/store') ?>" method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <!-- Product Name -->
                        <div class="col-sm-6">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter product name" required>
                        </div>
                        <!-- Barcode -->
                        <div class="col-sm-6">
                            <label for="barcode" class="form-label">Product Barcode</label>
                            <input type="text" class="form-control" name="product_barcode" id="barcode" placeholder="Enter product barcode" required>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <!-- Category -->
                        <div class="col-sm-6">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="category" required>
                                <option value="" disabled selected>Select a category</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= esc($category['id']); ?>">
                                            <?= esc($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No categories available</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <!--  brand Name -->
                        <div class="col-sm-6">
                            <label for="brand" class="form-label">Brand Name</label>
                            <select class="form-select" name="brand" id="brand" required>
                                <option value="" selected disabled>Select a brand</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id']; ?>"><?= $brand['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a brand.</div>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <!-- Tax -->
                        <div class="col-sm-6">
                            <label for="tax" class="form-label">Tax</label>
                            <input type="text" class="form-control" name="tax" id="tax" placeholder="Enter tax" required>
                        </div>

                        <!-- Tax type -->
                        <div class="col-sm-6">
                            <label for="tax_type" class="form-label">Tax Type:</label>
                            <select name="tax_type" class="form-select">
                                <option class="form-label" value="percent">Percent</option>
                                <option class="form-label" value="fixed">Fixed</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Product type  -->
                        <div class="col-sm-6">
                            <label for="product_type" class="form-label">Product Type:</label>
                            <select name="product_type" class="form-select">
                                <option class="form-label" value="standard product">Standard product</option>
                                <option class="form-label" value="variable produuct">Variable product</option>
                                <option class="form-label" value="combo produuct">Combo product</option>
                                <option class="form-label" value="service produuct">Service product</option>
                            </select>
                        </div>

                        <!-- Image -->
                        <div class="col-sm-6">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="img" id="image">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Product unit -->
                        <div class="col-sm-6">
                            <label for="product_unit" class="form-label">Product Unit</label>
                            <select class="form-select" name="product_unit" id="product_unit" required>
                                <option value="" disabled selected>Select a unit</option>
                                <?php if (!empty($units)): ?>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?= esc($unit['id']); ?>">
                                            <?= esc($unit['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No units available</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- purchase unit -->
                        <div class="col-sm-6">
                            <label for="purchase_unit" class="form-label">Purchase Unit</label>
                            <select class="form-select" name="purchase_unit" id="product_unit" required>
                                <option value="" disabled selected>Select a unit</option>
                                <?php if (!empty($units)): ?>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?= esc($unit['id']); ?>">
                                            <?= esc($unit['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No units available</option>
                                <?php endif; ?>
                            </select>
                        </div>


                    </div>

                    <div class="row mb-3">
                        <!-- sale unit -->
                        <div class="col-sm-6">
                            <label for="sale_unit" class="form-label">Sale Unit</label>
                            <select class="form-select" name="sale_unit" id="product_unit" required>
                                <option value="" disabled selected>Select a unit</option>
                                <?php if (!empty($units)): ?>
                                    <?php foreach ($units as $unit): ?>
                                        <option value="<?= esc($unit['id']); ?>">
                                            <?= esc($unit['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No units available</option>
                                <?php endif; ?>
                            </select>
                        </div>


                        <!-- Stock alert -->
                        <div class="col-sm-6">
                            <label for="stock_alert" class="form-label">Stock Alert</label>
                            <input type="number" class="form-control" name="stock_alert" id="stock_alert" placeholder="Enter stock alert" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <!-- Available Stock -->
                        <div class="col-sm-6">
                            <label for="stock" class="form-label">Available Stock</label>
                            <input type="number" class="form-control" name="available_stock" id="stock" placeholder="Enter stock quantity" required>
                        </div>
                        <!-- Price -->
                        <div class="col-sm-6">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" id="price" placeholder="Enter price" required>
                        </div>

                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter product description"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <script>
        document.getElementById('product_unit').addEventListener('change', function() {
            const unitId = this.value;

            if (unitId) {
                fetch('<?= base_url('product/getUnitDetails'); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            unit_id: unitId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const {
                                name,
                                base_unit
                            } = data.data;

                            // Update Purchase Unit
                            const purchaseUnit = document.getElementById('purchase_unit');
                            purchaseUnit.innerHTML = `<option value="${unitId}">${name} (Base: ${base_unit})</option>`;

                            // Update Sale Unit
                            const saleUnit = document.getElementById('sale_unit');
                            saleUnit.innerHTML = `<option value="${unitId}">${name} (Base: ${base_unit})</option>`;
                        } else {
                            alert(data.message || 'Something went wrong!');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>