<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product DataTable</title>

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
</head>
<body>

    <h1>Product List</h1>

    <table id="productsTable" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Price</th>
                <th>Barcode</th>
                <th>Unit</th>
                <th>Description</th>
                <th>Stock</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be populated via AJAX -->
        </tbody>
    </table>

    <!-- Initialize DataTable -->
    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= site_url('product/datatable'); ?>",
                    "type": "GET"
                }
            });
        });
    </script>

</body>
</html>
