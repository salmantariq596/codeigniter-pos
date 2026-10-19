<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <title>All Purchases</title>
</head>

<body>
    <?= $this->extend('layout/layout') ?>
    <?= $this->section('content') ?>

    <div class="container my-5">
        <h1 class="mb-4">All Purchases</h1>
        <a href="<?= base_url('purchases/addPurchase') ?>" class="btn btn-primary mb-3">Add Purchase</a>
        <table class="table table-bordered">
            <thead class="">
                <tr>
                    <th scope="col">Purchase ID</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Warehouse</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Pay Amount</th>
                    <th scope="col">Pending Amount</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?= $purchase['id'] ?></td>
                        <td><?= $purchase['vendor_name'] ?></td>
                        <td><?= isset($purchase['warehouse_name']) ? $purchase['warehouse_name'] : ''; ?></td>

                        <td><?= date('d M, Y', strtotime($purchase['purchase_date'])) ?></td>
                        <td><?= number_format($purchase['total_amount'], 2) ?></td>
                        <td><?= number_format($purchase['pay_amount'], 2); ?></td>
                        <td><?= number_format($purchase['pending_amount'], 2); ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('purchases/editPurchase/' . $purchase['id']) ?>" class="btn btn-sm btn-primary me-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="<?= base_url('purchases/deletePurchase/' . $purchase['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this purchase?')">
                                <i class="bi bi-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $this->endSection() ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>