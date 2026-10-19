<?php

namespace App\Controllers\Admin;

use App\Models\PurchaseModel;
use App\Models\PurchaseDetailModel;
use App\Models\VendorModel;
use App\Models\WarehouseModel;
use App\Models\ProductModel as ProdModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PurchasesController extends BaseController
{
    public function allPurchasesold()
    {
        $purchaseModel = new PurchaseModel();
        $data['purchases'] = $purchaseModel->getPurchases(); // Fetch all purchases with total amount

        return $this->render('purchase/all_purchases', $data);
    }
    public function allPurchases()
    {
        // Get DataTables parameters from the request

        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';

        // Load the PurchaseModel
        $purchaseModel = new \App\Models\PurchaseModel();

        // Base query
        $query = $purchaseModel->select('purchases.*, vendors.name as vendor_name')
            ->join('vendors', 'vendors.id = purchases.vendor_id', 'left'); // Adjust relationships as needed
        // Apply search filter
        if (!empty($searchValue)) {
            $query->groupStart()
                ->like('purchases.invoice_number', $searchValue)
                ->orLike('vendors.name', $searchValue)
                ->orLike('purchases.total_amount', $searchValue)
                ->groupEnd();
        }

        // Clone query to get filtered record count
        $filteredQuery = clone $query;
        $filteredRecords = $filteredQuery->countAllResults(false); // Count without resetting query

        // Apply pagination
        $query->limit($length, $start);

        // Fetch filtered data
        $purchases = $query->get()->getResultArray();
        // Total records count
        $totalRecords = $purchaseModel->countAll();

        // Prepare DataTables response
        $response = [
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $purchases,
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }


    public function addPurchase()
    {
        $vendorModel = new VendorModel();
        $productModel = new ProdModel();
        $warehouseModel = new WarehouseModel();

        // Get all vendors and products for dropdowns
        $data['vendors'] = $vendorModel->findAll();
        $data['products'] = $productModel->findAll();
        $data['warehouses'] = $warehouseModel->findAll();

        // Calculate total amount if products are selected
        $totalAmount = 0;
        $products = $this->request->getPost('products');

        if ($products) {
            foreach ($products as $product) {
                $totalAmount += $product['quantity'] * $product['price'];
            }
        }

        $data['total_amount'] = $totalAmount;

        return $this->render('purchase/add_purchase', $data);
    }

    public function savePurchase()
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProdModel();

        // Get purchase data from the form
        $vendorId = $this->request->getPost('vendor_id');
        $warehousesId = $this->request->getPost('warehouses_id');
        $products = $this->request->getPost('products');
        $payAmount = $this->request->getPost('pay_amount');
        $totalAmount = $this->request->getPost('total_amount');

        // Calculate total amount dynamically in case it is not already set
        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product['quantity'] * $product['price'];
        }

        // Calculate the pending amount
        $pendingAmount = $totalAmount - $payAmount;

        // Save the purchase
        $purchaseData = [
            'vendor_id' => $vendorId,
            'warehouses_id' => $warehousesId,
            'purchase_date' => date('Y-m-d H:i:s'),
            'total_amount' => $totalAmount,  // Save the calculated total amount
            'pay_amount' => $payAmount,      // Save the pay amount
            'pending_amount' => $pendingAmount, // Save the calculated pending amount
        ];

        $purchaseId = $purchaseModel->insert($purchaseData);

        // Add purchase details
        foreach ($products as $product) {
            $purchaseDetailData = [
                'purchase_id' => $purchaseId,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price']
            ];

            // Update product stock
            $productModel->updateStock($product['product_id'], $product['quantity']);

            // Save purchase details
            $purchaseDetailModel->save($purchaseDetailData);
        }

        return redirect()->to('datatable/allPurchases');
    }

    public function editPurchase($id)
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $vendorModel = new VendorModel();
        $warehouseModel = new WarehouseModel();
        $productModel = new ProdModel();

        // Get the purchase and its details
        $data['purchase'] = $purchaseModel->find($id);
        $data['purchase_details'] = $purchaseDetailModel->getDetailsByPurchaseId($id);
        $data['vendors'] = $vendorModel->findAll();
        $data['products'] = $productModel->findAll();
        $data['warehouses'] = $purchaseModel->findAll();

        return $this->render('purchase/edit_purchase', $data);
    }

    public function updatePurchase($id)
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProdModel();
        $warehouseModel = new WarehouseModel();

        // Get purchase data from the form
        $vendorId = $this->request->getPost('vendor_id');
        $warehouseId = $this->request->getPost('warehouse_id');
        $products = $this->request->getPost('products');
        $payAmount = $this->request->getPost('pay_amount');
        $totalAmount = $this->request->getPost('total_amount');

        // Calculate the total amount dynamically (if not already set)
        $totalAmount = 0;
        foreach ($products as $product) {
            $totalAmount += $product['quantity'] * $product['price'];
        }

        // Calculate the pending amount
        $pendingAmount = $totalAmount - $payAmount;

        // Update the purchase
        $purchaseData = [
            'vendor_id' => $vendorId,
            'warehouse_id' => $warehouseId,
            'purchase_date' => date('Y-m-d H:i:s'),
            'total_amount' => $totalAmount,   // Save the calculated total amount
            'pay_amount' => $payAmount,       // Save the pay amount
            'pending_amount' => $pendingAmount,  // Save the calculated pending amount
        ];

        $purchaseModel->update($id, $purchaseData);

        // Delete old purchase details
        $purchaseDetailModel->where('purchase_id', $id)->delete();

        // Add new purchase details
        foreach ($products as $product) {
            $purchaseDetailData = [
                'purchase_id' => $id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'price' => $product['price']
            ];

            // Update product stock
            $productModel->updateStock($product['product_id'], $product['quantity']);

            // Save purchase details
            $purchaseDetailModel->save($purchaseDetailData);
        }

        return redirect()->to('/purchases/allPurchases');
    }

    public function deletePurchase($id)
    {
        $purchaseModel = new PurchaseModel();
        $purchaseDetailModel = new PurchaseDetailModel();
        $productModel = new ProdModel();

        // Get purchase details to reduce stock
        $purchaseDetails = $purchaseDetailModel->getDetailsByPurchaseId($id);

        // Update stock before deleting
        foreach ($purchaseDetails as $detail) {
            $productModel->updateStock($detail['product_id'], -$detail['quantity']);
        }

        // Delete purchase details and purchase
        $purchaseDetailModel->where('purchase_id', $id)->delete();
        $purchaseModel->delete($id);

        return redirect()->to('/purchases/allPurchases');
    }
}
