<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Invoice History</title>
</head>
<body>
    <?= $this->extend('layout/layout') ?>
    
    <?= $this->section('content') ?>
    <div class="container mt-5">
        <h2>Invoice History</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer ID</th>
                    <th>Warehouse ID</th>
                    <th>Total Amount</th>
                    <th>Sale Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= $sale['id'] ?></td>
                        <td><?= $sale['customer_id'] ?></td>
                        <td><?= $sale['warehouse_id'] ?></td>
                        <td><?= $sale['total_amount'] ?></td>
                        <td><?= $sale['sale_date'] ?></td>
                        <td>
                            <button 
                                class="btn btn-info btn-sm view-sale-btn" 
                                data-sale-id="<?= $sale['id'] ?>"
                                data-bs-toggle="modal" 
                                data-bs-target="#saleModal"
                            >
                                View
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Sale Modal -->
    <div class="modal fade" id="saleModal" tabindex="-1" aria-labelledby="saleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saleModalLabel">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="saleDetails"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="printInvoiceBtn" class="btn btn-primary">Print</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).on('click', '.view-sale-btn', function () {
        const saleId = $(this).data('sale-id');
        $.ajax({
            url: "<?= base_url('pos/getSaleDetails') ?>/" + saleId,
            method: 'GET',
            success: function (response) {
                let html = `
                    <p><strong>Customer ID:</strong> ${response.sale.customer_id}</p>
                    <p><strong>Warehouse ID:</strong> ${response.sale.warehouse_id}</p>
                    <p><strong>Sale Date:</strong> ${response.sale.sale_date}</p>
                    <h5>Items:</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                // Loop through the sale items
                response.items.forEach((item, index) => {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.product_name}</td>
                            <td>${item.price}</td>
                            <td>${item.quantity}</td>
                            <td>${item.subtotal}</td>
                        </tr>
                    `;
                });

                html += `</tbody></table>`;

                // Calculate the Pending Amount
                const totalAmount = parseFloat(response.sale.total_amount);
                const receivedAmount = parseFloat(response.sale.received_amount);
                const pendingAmount =  receivedAmount - totalAmount;

                // Display the total, received, and calculated pending amounts
                html += `
                    <h5>Total Summary:</h5>
                    <p><strong>Total Amount:</strong> $${totalAmount.toFixed(2)}</p>
                    <p><strong>Received Amount:</strong> $${receivedAmount.toFixed(2)}</p>
                    <p><strong>Change Amount:</strong> $${pendingAmount.toFixed(2)}</p>
                `;

                $('#saleDetails').html(html);
            }
        });
    });

    $('#printInvoiceBtn').click(function () {
        const printContents = document.getElementById('saleDetails').innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    });
</script>
<?= $this->endSection() ?>



</body>
</html>
