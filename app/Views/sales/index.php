<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>POS & Sales History</title>
</head>

<body>
    <div class="container mt-5">
        <!-- POS Form -->
        <h3>Point of Sale (POS)</h3>
        <form action="<?= site_url('pos/makeSale') ?>" method="POST">
            <div class="mb-3">
                <label for="products" class="form-label">Products</label>
                <!-- You can list your products and quantities here -->
                <input type="text" class="form-control" name="products" id="products" required>
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Amount</label>
                <input type="number" class="form-control" name="total_amount" id="total_amount" required>
            </div>
            <button type="submit" class="btn btn-success">Make Sale</button>
        </form>

        <hr>

        <!-- All Sales History -->
        <h3 class="mt-5">All Sales History</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= esc($sale['id']) ?></td>
                            <td><?= esc($sale['sale_date']) ?></td>
                            <td>$<?= number_format($sale['total_amount'], 2) ?></td>
                            <td>
                                <a href="<?= site_url('pos/view_invoice/' . $sale['id']) ?>" class="btn btn-info btn-sm">View Invoice</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>