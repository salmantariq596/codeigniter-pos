<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AppVersion;
use App\Models\SaleModel;
use App\Models\PurchaseModel;
use App\Models\ExpenseModel;

class AdminDashboard extends BaseController
{
    protected $userModel;
    protected $salesModel;
    protected $purchaseModel;
    protected $expenseModel;
    protected $versionNumber;

    public function __construct()
    {
        parent::__construct();
        $this->salesModel = new SaleModel();
        $this->purchaseModel = new PurchaseModel();
        $this->expenseModel = new ExpenseModel();
    }

    public function welcome_message()
    {
        // Get totals
        $totalAmount = $this->salesModel->getTotalSales();
        $totalPurchases = $this->purchaseModel->getTotalPurchases();
        $totalExpenses = $this->expenseModel->getTotalExpenses();
    
        return $this->render('welcome_message', [
            'data' => 'value',
            'totalAmount' => $totalAmount,
            'totalPurchases' => $totalPurchases,
            'totalExpenses' => $totalExpenses,
        ]);
    }

    public function getRevenueData()
{
    // Assuming methods to fetch the dynamic data
    $salesData = $this->salesModel->getMonthlySalesData(); // [24000, 25000, 27000, ...]
    $purchasesData = $this->purchaseModel->getMonthlyPurchasesData(); // [15000, 15000, 16000, ...]

    return $this->response->setJSON([
        'sales' => $salesData,
        'purchases' => $purchasesData,
        'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']
    ]);
}

}