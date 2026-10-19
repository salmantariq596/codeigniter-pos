<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>POS - Add Sales</title>
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #4f46e5;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --background: #f1f5f9;
            --card-bg: #ffffff;
            --text: #1e293b;
            --border: #e2e8f0;
        }

        body {
            background-color: var(--background);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            /* background: linear-gradient(to right, var(--primary), var(--secondary)); */
            background-color: #FFFFFF;
            padding: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            color: #f59e0b;
        }

        .navbar h2 {
            color: blue !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Card Styling */
        .card {
            background: var(--card-bg);
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Product Card */
        .product-card {
            width: 160px;
            margin: 0.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .product-card img {
            height: 100px;
            object-fit: cover;
            border-radius: 1rem 1rem 0 0;
        }

        .product-card .card-body {
            padding: 0.75rem;
            text-align: center;
        }

        .product-card .btn {
            width: 90%;
            margin: 0.5rem auto;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .barcode-img {
            width: 7%;
        }

        /* Search Bar */
        .search-bar-container {
            display: flex;
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1rem;
            margin: 1rem 0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .search-bar-container input {
            border-radius: 0.5rem;
            border: 2px solid var(--border);
            padding: 1rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .search-bar-container input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Buttons */
        .btn {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success);
            border: none;
        }

        .btn-danger {
            background: var(--danger);
            border: none;
        }

        /* Category Buttons */
        .category-btn {
            background: var(--card-bg);
            border: 2px solid var(--border);
            margin: 0.25rem;
            border-radius: 2rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .category-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .category-btn.active {
            background: var(--success);
            color: white;
            border-color: var(--success);
            transform: scale(1.05);
        }

        /* Tables */
        .table {
            background: var(--card-bg);
            border-radius: 1rem;
            overflow: hidden;
        }

        .table th {
            background: var(--primary);
            color: white;
            font-weight: 500;
        }

        .table td {
            vertical-align: middle;
        }

        /* Modal */
        .modal-content {
            border-radius: 1rem;
            border: none;
        }

        .modal-header {
            background: var(--primary);
            color: white;
            border-radius: 1rem 1rem 0 0;
        }

        .modal-footer {
            border-radius: 0 0 1rem 1rem;
        }

        /* Form Controls */
        .form-control,
        .form-select {
            border-radius: 0.5rem;
            border: 2px solid var(--border);
            padding: 0.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table tbody tr {
            animation: slideIn 0.3s ease forwards;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }
    </style>
</head>

<body>
    <div class="container-fluid px-0">

        <div class="d-flex align-items-start justify-content-between">
            <div style="width: 40%;">
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            <h1 style="color: orange; margin-left: 3px; margin-bottom: 0px;">
                                <i class="bi bi-postcard"></i>
                            </h1>
                            <h2 class="offcanvas-title text-primary" id="offcanvasExampleLabel">POS Lite</h2>
                        </div>
                        <div>
                            <a href="<?= site_url('/dashboard-new') ?>" class="btn btn-success">Dashboard</a>
                            <div class="btn btn-light">Add users</div>
                        </div>
                    </div>
                </nav>

                <div class="card" style="height: 500px;  overflow: scroll;">
                    <div class="card-body">

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="customerSelect">Customer</label>
                            <select class="form-select" id="customerSelect" name="customer_id">
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?= $customer['id']; ?>"><?= $customer['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="warehouseSelect">Warehouse</label>
                            <select class="form-select" id="warehouseSelect" name="warehouse_id">
                                <?php foreach ($warehouses as $warehouse): ?>
                                    <option value="<?= $warehouse['id']; ?>"><?= $warehouse['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <table class="table table-sm table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="billItems"></tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <h4 class="btn btn-primary w-100">Total: $<span id="totalAmount">0.00</span></h4>
                        </div>
                    </div>
                    
                    <div class="container mt-4">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Enter discount" aria-label="Discount percentage">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Enter tax" aria-label="Tax percentage">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 custom-gap" style="margin-left: 5px;">
                        <button class="btn btn-danger col-sm-6 text-white" style="width: 49%;">
                            <i class="bi bi-power"></i>
                            Reset
                        </button>
                        <button class="btn btn-success col-sm-6" style="width: 49%;" id="printBillDetails" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                            <i class="bi bi-cart3"></i>
                            Pay Now
                        </button>
                    </div>
                </div>


            </div>

            <div style="width: 60%; padding-left: 10px;">
                <nav class="navbar navbar-light bg-light">
                    <div class="container-fluid row" style="padding-right: 3px;">
                        <a href="#" class="btn btn-lg btn-primary col-sm-6" style="width: 49.5%;" id="listCategoriesBtn">List of Categories</a>

                        <a href="" class="btn btn-lg btn-primary col-sm-6" style="width: 49.5%;">List of Brands</a>
                    </div>
                </nav>

                <div class="search-bar-container mx-auto">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLMSy-RghVV9Ip3g7OBfu2lEZUjXVZUpdQYQ&s" alt="Barcode" class="barcode-img">
                    <input type="text" class="form-control" style="height: 10vh;" placeholder="Product name / Barcode....." onkeyup="filterProducts()">
                </div>
                <div id="categories-list" class="container my-4">
                    <!-- Categories will be displayed here -->
                </div>

                <!-- Products List Section (Empty initially) -->
                <div id="products-list" class="container my-4 d-flex flex-wrap">
                    <!-- Products will be displayed here as cards -->
                </div>
                <div class="d-flex flex-wrap gap-3"> <!-- Added gap for product cards -->
                    <?php foreach ($products as $product): ?>
                        <div class="card product-card"
                            style="padding: 0;"
                            data-barcode="<?= esc($product['product_barcode']) ?>"
                            data-id="<?= esc($product['id']) ?>"
                            data-stock="<?= esc($product['available_stock']) ?>">
                            <img src="<?= base_url('uploads/' . $product['img']) ?>" class="card-img-top rounded-4" style="height: 80px; object-fit: cover;">
                            <div class="card-body px-0 mx-auto">
                                <h5 class="card-title" style="font-size: 14px; margin-bottom: 3px;">
                                    <?= esc($product['name']) ?>
                                </h5>
                                <p class="card-text mb-0 badge text-bg-primary" style="font-size: 12px;">
                                    $<?= number_format($product['price'], 2) ?>
                                </p>
                                <p class="card-text mb-0" style="font-size: 14px;">
                                    <i class="bi bi-upc-scan" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Barcode"></i>
                                    <?= esc($product['product_barcode']) ?>
                                </p>

                                <button class="btn btn-sm btn-primary w-100" onclick="addToBill(<?= htmlspecialchars(json_encode($product), ENT_QUOTES, 'UTF-8') ?>)">
                                    Add to Bill
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>


            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="billDetails" class="mb-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="modalBillItems"></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>$<span id="modalTotalAmount">0.00</span></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentMethod">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="upi">UPI</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Received Amount</label>
                        <input type="number" class="form-control" id="receivedAmount" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change</label>
                        <input type="text" class="form-control" id="changeAmount" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="printBill()">Print</button>
                    <button class="btn btn-success" onclick="finalizeCheckout()">Complete Sale</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fetch categories when the button is clicked
        $('#listCategoriesBtn').on('click', function() {
            $.ajax({
                url: '/productcontroller/fetchCategories', // Controller method URL
                type: 'GET',
                success: function(response) {
                    let categoriesList = $('#categories-list');
                    categoriesList.empty(); // Clear previous list
                    response.forEach(function(category) {
                        categoriesList.append(`<button class="btn btn-light category-btn" data-category-id="${category.id}">${category.name}</button>`);
                        $('.category-btn').on('click', function() {
                            // Remove the 'active' class from all buttons
                            $('.category-btn').removeClass('active');

                            // Add the 'active' class to the clicked button
                            $(this).addClass('active');
                        });
                    });
                }
            });
        });

        // Fetch products when a category is clicked
        $(document).on('click', '.category-btn', function() {
            let categoryId = $(this).data('category-id');
            $.ajax({
                url: '/productcontroller/fetchCategories/' + categoryId, // Controller method URL
                type: 'GET',
                success: function(response) {
                    let productsList = $('#products-list');
                    productsList.empty(); // Clear previous products
                    if (response.length > 0) {
                        response.forEach(function(product) {
                            productsList.append(`
                        <div class="card m-2 product-card">
                            <img src="${product.image_url}" class="card-img-top rounded-4" style="height: 80px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title" style="font-size: 14px; margin-bottom: 3px;">${product.name}</h5>
                                <p class="card-text mb-0 badge text-bg-primary" style="font-size: 12px;">
                                    $${parseFloat(product.price).toFixed(2)}
                                </p>
                                <p class="card-text mb-0" style="font-size: 14px;">
                                    <i class="bi bi-upc-scan" data-bs-toggle="tooltip" data-bs-placement="top" title="Product Barcode"></i>
                                    ${product.product_barcode}
                                </p>
                                <button class="btn btn-sm btn-primary w-100" onclick="addToBill(${JSON.stringify(product)})">
                                    Add to Bill
                                </button>
                            </div>
                        </div>
                    `);
                        });
                    } else {
                        productsList.append('<p>No products found in this category.</p>');
                    }
                },
                error: function() {
                    alert('Error fetching products.');
                },
            });
        });
    </script>
    <style>
        /* Apply green color when the button is active */
        .category-btn.active {
            background-color: #4F46E5;
            color: white;
            border-color: #4F46E5;
            /* Optional: Add border color */
        }
    </style>
    <script>
        function filterProducts() {
            var input = document.querySelector('.search-bar-container input');
            var searchValue = input.value.toLowerCase();
            var productCards = document.querySelectorAll('.product-card');

            // Check if input matches exact barcode
            var barcodeMatch = Array.from(productCards).find(card =>
                card.dataset.barcode.toLowerCase() === searchValue
            );

            if (barcodeMatch) {
                // Extract all necessary product data from the card
                const cardBody = barcodeMatch.querySelector('.card-body');
                const productData = {
                    id: parseInt(barcodeMatch.dataset.id),
                    name: cardBody.querySelector('.card-title').textContent.trim(),
                    price: parseFloat(cardBody.querySelector('.badge').textContent.replace('$', '')),
                    product_barcode: barcodeMatch.dataset.barcode,
                    available_stock: parseInt(barcodeMatch.dataset.stock || '0'),
                    img: barcodeMatch.querySelector('.card-img-top').src
                };

                // Find if item already exists in bill
                const existingItem = bill.find(item => item.id === productData.id);
                const newQuantity = existingItem ? existingItem.quantity + 1 : 1;

                // Check stock before adding
                if (newQuantity > productData.available_stock) {
                    alert(`Insufficient stock for "${productData.name}". Available stock: ${productData.available_stock}`);
                    input.value = '';
                    return;
                }

                // Add to bill and clear input
                addToBill(productData);
                input.value = '';
                hideSuggestions();
                return;
            }

            // If no barcode match, show name-based suggestions
            let suggestions = Array.from(productCards)
                .filter(card => {
                    var productName = card.querySelector('.card-title').textContent.toLowerCase();
                    return productName.includes(searchValue);
                })
                .slice(0, 5); // Limit to 5 suggestions

            showSuggestions(suggestions, input);
        }

        // Create and show suggestions dropdown
        function showSuggestions(suggestions, inputElement) {
            // Remove existing suggestions
            hideSuggestions();

            if (!suggestions.length || !inputElement.value) return;

            // Create suggestions container
            const suggestionsDiv = document.createElement('div');
            suggestionsDiv.className = 'suggestions-container position-absolute bg-white w-100 shadow-sm border rounded-bottom';
            suggestionsDiv.style.zIndex = '1000';

            suggestions.forEach(card => {
                const cardBody = card.querySelector('.card-body');
                const suggestion = document.createElement('div');
                suggestion.className = 'suggestion-item p-2 border-bottom cursor-pointer hover:bg-gray-100 d-flex justify-content-between align-items-center';

                // Create product info with name and price
                const productInfo = document.createElement('div');
                productInfo.innerHTML = `
            <div>${cardBody.querySelector('.card-title').textContent}</div>
            <small class="text-muted">${cardBody.querySelector('.badge').textContent}</small>
        `;
                suggestion.appendChild(productInfo);

                suggestion.addEventListener('click', () => {
                    const productData = {
                        id: parseInt(card.dataset.id),
                        name: cardBody.querySelector('.card-title').textContent.trim(),
                        price: parseFloat(cardBody.querySelector('.badge').textContent.replace('$', '')),
                        product_barcode: card.dataset.barcode,
                        available_stock: parseInt(card.dataset.stock || '0'),
                        img: card.querySelector('.card-img-top').src
                    };

                    // Check stock before adding
                    const existingItem = bill.find(item => item.id === productData.id);
                    const newQuantity = existingItem ? existingItem.quantity + 1 : 1;

                    if (newQuantity > productData.available_stock) {
                        alert(`Insufficient stock for "${productData.name}". Available stock: ${productData.available_stock}`);
                        return;
                    }

                    addToBill(productData);
                    inputElement.value = '';
                    hideSuggestions();
                });

                suggestionsDiv.appendChild(suggestion);
            });

            // Insert suggestions after input
            inputElement.parentNode.style.position = 'relative';
            inputElement.parentNode.appendChild(suggestionsDiv);
        }

        // Hide suggestions dropdown
        function hideSuggestions() {
            const existing = document.querySelector('.suggestions-container');
            if (existing) existing.remove();
        }

        // Add click event listener to document to hide suggestions when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-bar-container')) {
                hideSuggestions();
            }
        });

        // Add these CSS styles to your stylesheet
        const styles = `
.suggestions-container {
    max-height: 300px;
    margin-top: 100px;
    overflow-y: auto;
}

.suggestion-item {
    cursor: pointer;
}

.suggestion-item:hover {
    background-color: #f8f9fa;
}

.search-bar-container {
    position: relative;
}

.suggestion-item small {
    font-size: 0.875em;
}
`;

        // Add styles to document
        const styleSheet = document.createElement('style');
        styleSheet.textContent = styles;
        document.head.appendChild(styleSheet);
    </script>


    <script>
       let bill = [];
const beepSound = new Audio('/audio/beep.wav');

// Update bill table display
function updateBillTable() {
    const billItems = document.getElementById('billItems');
    const modalBillItems = document.getElementById('modalBillItems');
    let total = 0;

    // Clear existing content
    billItems.innerHTML = '';
    if (modalBillItems) {
        modalBillItems.innerHTML = '';
    }

    // Update both main bill table and modal table
    bill.forEach(item => {
        total += item.subtotal;
        
        // Update main bill table
        billItems.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.quantity}</td>
                <td>$${item.price.toFixed(2)}</td>
                <td>$${item.subtotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeFromBill(${item.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        // Update modal table if it exists
        if (modalBillItems) {
            modalBillItems.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price.toFixed(2)}</td>
                    <td>$${item.subtotal.toFixed(2)}</td>
                </tr>
            `;
        }
    });

    // Update total amounts
    document.getElementById('totalAmount').innerText = total.toFixed(2);
    const modalTotalAmount = document.getElementById('modalTotalAmount');
    if (modalTotalAmount) {
        modalTotalAmount.innerText = total.toFixed(2);
    }
}

// Add item to bill
function addToBill(product) {
    // Ensure product.id is consistently a number
    const productId = parseInt(product.id);
    
    // Find existing item using the normalized product ID
    const existingItem = bill.find(item => parseInt(item.id) === productId);
    
    // Calculate new quantity
    const newQuantity = existingItem ? existingItem.quantity + 1 : 1;
    
    // Check stock availability
    if (newQuantity > parseInt(product.available_stock)) {
        alert(`Insufficient stock for "${product.name}". Available stock: ${product.available_stock}`);
        return;
    }
    
    // Play beep sound
    beepSound.play();
    
    if (existingItem) {
        // Update existing item
        existingItem.quantity = newQuantity;
        existingItem.subtotal = existingItem.quantity * existingItem.price;
    } else {
        // Add new item
        bill.push({
            id: productId,
            name: product.name,
            quantity: 1,
            price: parseFloat(product.price),
            subtotal: parseFloat(product.price),
            available_stock: parseInt(product.available_stock)
        });
    }
    
    updateBillTable();
}

// Remove item from bill
function removeFromBill(itemId) {
    // Convert itemId to number for consistent comparison
    const numericId = parseInt(itemId);
    bill = bill.filter(item => parseInt(item.id) !== numericId);
    updateBillTable();
}

// Update modal content
function updateModalContent() {
    updateBillTable();
}

// Finalize checkout
function finalizeCheckout() {
    const receivedAmount = parseFloat(document.getElementById('receivedAmount').value) || 0;
    const totalAmount = parseFloat(document.getElementById('modalTotalAmount').innerText.replace('$', ''));
    const paymentMethod = document.getElementById('paymentMethod').value;
    const customerId = document.getElementById('customerSelect').value;
    const warehouseId = document.getElementById('warehouseSelect').value;

    if (receivedAmount < totalAmount) {
        alert('Insufficient payment');
        return;
    }

    const change = receivedAmount - totalAmount;
    document.getElementById('changeAmount').value = change.toFixed(2);

    // Prepare sale data
    const saleData = {
        customer_id: customerId,
        warehouse_id: warehouseId,
        total_amount: totalAmount,
        received_amount: receivedAmount,
        change_amount: change,
        payment_method: paymentMethod,
        items: bill.map(item => ({
            product_id: item.id,
            quantity: item.quantity,
            price: item.price,
            subtotal: item.subtotal
        }))
    };

    // Save sale
    fetch('/sales/save', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(saleData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sale completed successfully!');
            printBill();
            bill = [];
            updateBillTable();
            $('#checkoutModal').modal('hide');
        } else {
            alert('Error: ' + (data.message || 'Failed to process sale'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error processing sale. Please try again.');
    });
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Add modal event listener
    const checkoutModal = document.getElementById('checkoutModal');
    if (checkoutModal) {
        checkoutModal.addEventListener('show.bs.modal', updateModalContent);
    }
});

        function printBill() {
            const modalBillItems = document.getElementById('modalBillItems');
            const modalTotalAmountElement = document.getElementById('modalTotalAmount');

            if (!modalBillItems || !modalTotalAmountElement) {
                console.error('Modal elements not found');
                return; // Exit the function if elements are not found
            }

            const modalTotalAmount = modalTotalAmountElement.innerText;

            // Create printable content
            let printContent = `
    <div class='mx-auto'>
        <h3>Poslite</h3>
        <h5>Customer Invoice</h5>
        
        </div>
        <table border="1" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                ${modalBillItems.innerHTML}
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>$${modalTotalAmount}</th>
                </tr>
            </tfoot>
        </table>
        
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLMSy-RghVV9Ip3g7OBfu2lEZUjXVZUpdQYQ&s" alt="Barcode" style="width: 25%; text-align: center;">

        <h5>Thank You For Shopping!</h5>
    `;

            // Open a new window and write the print content
            const newWindow = window.open('', '', 'height=600,width=400');
            newWindow.document.write(printContent);
            newWindow.document.close();
            newWindow.print();
        }
    </script>

</body>

</html>