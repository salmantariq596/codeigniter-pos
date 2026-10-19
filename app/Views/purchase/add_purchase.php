<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>Add Purchase</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add Purchase</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('purchases/savePurchase') ?>" method="post" id="purchase-form">
                    <div class="row">
                    <div class="mb-3 col-sm-6">
                        <label for="vendor_id" class="form-label">Vendor</label>
                        <select name="vendor_id" id="vendor_id" class="form-select">
                            <?php foreach ($vendors as $vendor): ?>
                                <option value="<?= $vendor['id'] ?>"><?= $vendor['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3 col-sm-6">
                        <label for="warehouses_id" class="form-label">warehouse</label>
                        <select name="warehouses_id" id="warehouses_id" class="form-select">
                            <?php foreach ($warehouses as $warehouse): ?>
                                <option value="<?= $warehouse['id'] ?>"><?= $warehouse['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    </div>

                    <div id="product-container">
                        <label class="form-label">Products</label>
                        <div class="product-row row mb-3" data-index="0">
                            <div class="col-md-4">
                                <select name="products[0][product_id]" class="form-select">
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['id'] ?>"><?= $product['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="products[0][quantity]" placeholder="Quantity" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="products[0][price]" placeholder="Price" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="pay_amount" placeholder="enter pay amount" class="form-control">
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Purchase</button>
                </form>
            </div>
        </div>
    </div>

    <?= $this->endSection() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>