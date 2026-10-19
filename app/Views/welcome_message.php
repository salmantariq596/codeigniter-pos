<?= $this->extend('layout/layout') ?>
<?= $this->section('content') ?>
    <style>
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .sales-card {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }

        .purchase-card {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }

        .expenses-card {
            background: linear-gradient(135deg, #FFC107 0%, #FFA000 100%);
        }

        .profit-loss-card {
            background: linear-gradient(135deg, #F44336 0%, #D32F2F 100%);
        }

        .dashboard-card h3 {
            color: white;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .dashboard-card p {
            color: white;
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0;
        }

        .card-icon {
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 10px;
        }

        .trend {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 10px;
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 30px;
            min-height: 400px;
        }

        .stat-title {
            color: #333;
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>

    <div class="container-fluid py-4">
        <!-- Summary Cards Row -->

        <div class="row g-4">
            <div class="col-md-6 mb-3">
                <div class="dashboard-card expenses-card">
                    <h3>POS LITE</h3>
                    <p>Good Evening!</p>
                    <h3></h3>

                    
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="dashboard-card purchase-card">
                    <h3></h3>
                    <h3 id="dateTime"></h3>
                    <p class="">Admin</p>
                </div>
            </div>
           
        </div>

        <div class="row g-4">
            <div class="col-md-3">
                <div class="dashboard-card sales-card">
                    <i class="fas fa-chart-line card-icon"></i>
                    <h3>Sales Amount</h3>
                    <p>$<?= number_format($totalAmount, 2) ?></p>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> +12% vs last month
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card purchase-card">
                    <i class="fas fa-shopping-cart card-icon"></i>
                    <h3>Purchase Amount</h3>
                    <p>$<?= isset($totalPurchases) ? number_format($totalPurchases, 2) : '0.00' ?></p>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> +8% vs last month
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card expenses-card">
                    <i class="fas fa-wallet card-icon"></i>
                    <h3>Expenses</h3>
                    <p>$<?= isset($totalExpenses) ? number_format($totalExpenses, 2) : '0.00' ?></p>
                    
                    <div class="trend">
                        <i class="fas fa-arrow-down"></i> -3% vs last month
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="dashboard-card profit-loss-card">
                    <i class="fas fa-chart-pie card-icon"></i>
                    <h3>Profit/Loss</h3>
                    <p>+ $5,000</p>
                    <div class="trend">
                        <i class="fas fa-arrow-up"></i> +15% vs last month
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Charts Row -->
        <div class="row mt-4">
            <!-- Revenue Trend Chart -->
            <div class="col-md-8">
                <div class="chart-container">
                    <h4 class="stat-title">Revenue Trends</h4>
                    <canvas id="revenueTrend"></canvas>
                </div>
            </div>
            <!-- Expense Distribution Chart -->
            <div class="col-md-4">
                <div class="chart-container">
                    <h4 class="stat-title">Expense Distribution</h4>
                    <canvas id="expenseDistribution"></canvas>
                </div>
            </div>
        </div>
    </div>


    <!-- Make sure jQuery is loaded first -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Load Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
    <script>
    function updateDateTime() {
        const dateTimeElement = document.getElementById('dateTime');
        const now = new Date();

        // Format the date and time
        const date = now.toLocaleDateString(); // Format: MM/DD/YYYY
        const time = now.toLocaleTimeString(); // Format: HH:MM:SS AM/PM

        // Update the content
        dateTimeElement.textContent = `${date} ${time}`;
    }

    // Call the function every second
    setInterval(updateDateTime, 1000);

    // Call it once initially to avoid delay
    updateDateTime();
</script>

    <!-- Initialize charts after document is ready -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                // Check if Chart.js is loaded
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded');
                    return;
                }

                // Revenue Trend Chart
                const revenueTrendCtx = document.getElementById('revenueTrend');
                if (revenueTrendCtx) {
                    new Chart(revenueTrendCtx.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                            datasets: [{
                                label: 'Sales',
                                data: [24000, 25000, 27000, 26000, 28000, 30000],
                                borderColor: '#4CAF50',
                                tension: 0.4
                            }, {
                                label: 'Purchases',
                                data: [15000, 15000, 16000, 15500, 16200, 17000],
                                borderColor: '#2196F3',
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Expense Distribution Chart
                const expenseDistributionCtx = document.getElementById('expenseDistribution');
                if (expenseDistributionCtx) {
                    new Chart(expenseDistributionCtx.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Operations', 'Marketing', 'Payroll', 'Utilities'],
                            datasets: [{
                                data: [1500, 1200, 1800, 500],
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'right'
                                }
                            }
                        }
                    });
                }
            } catch (error) {
                console.error('Error initializing charts:', error);
            }
        });
    </script>
    <script>// In your view (e.g., welcome_message.php)
$(document).ready(function() {
    $.get('/total-sales', function(data) {
        $('#totalSalesAmount').text('$' + data.total_amount);
    });
});
</script>
    <?= $this->endSection() ?>
