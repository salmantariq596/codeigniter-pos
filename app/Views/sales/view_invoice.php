<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Invoice - Sale #<?= esc($sale['id']) ?></title>
</head>
<body>
    <div class="container mt-5">
        <h3 class="mb-4">Invoice - Sale #<?= esc($sale['id']) ?></h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saleItems as $item): ?>
                    <tr>
                        <td><?= esc($item['product_id']) ?></td>
                        <td><?= esc($item['quantity']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>$<?= number_format($item['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total Amount: $<?= number_format($sale['total_amount'], 2) ?></h4>
        <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
    </div>
</body>
</html>
