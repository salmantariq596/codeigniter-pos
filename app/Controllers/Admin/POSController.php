<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\SaleItemModel;
use App\Models\SaleModel;
use App\Models\WarehouseModel;
use App\Models\CustomerModel;
use App\Controllers\BaseController;
use CodeIgniter\CLI\Console;
use CodeIgniter\HTTP\ResponseInterface;

class POSController extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $customerModel = new CustomerModel();  // Load Customer Model
        $warehouseModel = new WarehouseModel(); // Load Warehouse Model

        // Fetch data
        $data['products'] = $productModel->findAll();
        $data['customers'] = $customerModel->findAll(); // Get all customers
        $data['warehouses'] = $warehouseModel->findAll(); // Get all warehouses

        // Render the view and pass data
        return $this->render('sales/pos', $data);
    }

    // In POSController.php
 // In POSController.php
public function totalSales()
{
    $saleModel = new SaleModel(); // Load SaleModel

    // Fetch the total sales amount
    $totalSales = $saleModel->getTotalAmountSum();  // Ensure this method exists in the model
    $totalAmount = $totalSales['total_amount'] ?? 0; // Safely handle null value

    // Return the total sales amount (you can return it as JSON or in any format you want)
    return $this->response->setJSON(['total_amount' => number_format($totalAmount, 2)]);
}



    public function checkout()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $saleData = $this->request->getJSON(true);
            $this->validateStock($saleData['items']);

            $saleModel = new SaleModel();
            $saleItemModel = new SaleItemModel();
            $productModel = new ProductModel();

            // Create sale record
            $saleId = $saleModel->insert([
                'customer_id' => $saleData['customer_id'],
                'warehouse_id' => $saleData['warehouse_id'],
                'payment_method' => $saleData['payment_method'],
                'received_amount' => $saleData['received_amount'],
                'total_amount' => $saleData['total_amount'],
                'sale_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            foreach ($saleData['items'] as $item) {
                $saleItemModel->insert([
                    'sale_id' => $saleId,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update stock
                $product = $productModel->find($item['id']);
                $productModel->update($item['id'], [
                    'available_stock' => $product['available_stock'] - $item['quantity']
                ]);
            }

            $db->transComplete();
            return $this->response->setJSON(['status' => 'success', 'sale_id' => $saleId]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function viewInvoice($saleId)
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();

        $sale = $saleModel->find($saleId);
        $saleItems = $saleItemModel->where('sale_id', $saleId)->findAll();

        if ($sale) {
            $data = [
                'sale' => $sale,
                'saleItems' => $saleItems
            ];
            return $this->render('sales/view_invoice', $data);
        }

        return redirect()->to('/pos')->with('error', 'Sale not found');
    }

    public function makeSale()
    {
        $saleModel = new SaleModel();
        $saleItemModel = new SaleItemModel();

        $saleData = [
            'total_amount' => $this->request->getPost('total_amount'),
            'sale_date' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $saleModel->save($saleData);
        $saleId = $saleModel->insertID();

        foreach ($this->request->getPost('products') as $product) {
            $saleItemModel->save([
                'sale_id' => $saleId,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['subtotal'],
            ]);
        }

        return redirect()->to('/pos');
    }


    public function viewInvoiceHistory()

    {
        $saleModel = new SaleModel();
        $customerModel = new CustomerModel();
        $saleItemModel = new SaleItemModel();


        // Fetch all sales records
        $sales = $saleModel->findAll();

        // Enrich sales data with customer and item details
        foreach ($sales as &$sale) {
            $sale['customer'] = $customerModel->find($sale['customer_id']);
            $sale['items'] = $saleItemModel->where('sale_id', $sale['id'])->findAll();
        }

        // Pass data to the view
        $data['sales'] = $sales;

        return $this->render('sales/invoice_history', $data);
    }


    public function invoiceHistory()
    {
        $saleModel = new \App\Models\SaleModel();
        $sales = $saleModel->findAll();
    
        return $this->render('sales/invoice_history', ['sales' => $sales]);
    }
    public function getSaleDetails($saleId)
    {
        $saleModel = new \App\Models\SaleModel();
        $saleItemModel = new \App\Models\SaleItemModel();
    
        $sale = $saleModel->find($saleId);
        $items = $saleItemModel->where('sale_id', $saleId)->findAll();
    
        return $this->response->setJSON([
            'sale' => $sale,
            'items' => $items
        ]);
    }
        

    public function save()
    {
        $db = \Config\Database::connect();
        $db->transStart(); // Start transaction
    
        try {
            // Get JSON data
            $data = $this->request->getJSON();
            
            // Load models
            $saleModel = new SaleModel();
            $saleItemModel = new SaleItemModel();
            $productModel = new ProductModel();
    
            // Prepare sale data
            $saleData = [
                'customer_id' => $data->customer_id,
                'warehouse_id' => $data->warehouse_id,
                'received_amount' => $data->received_amount,
                'total_amount' => $data->total_amount,
                'change_amount' => $data->change_amount,
                'payment_method' => $data->payment_method,
                'sale_date' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s')
            ];
    
            // Insert sale and get ID
            $saleId = $saleModel->insert($saleData);
    
            if (!$saleId) {
                throw new \Exception('Failed to create sale record');
            }
    
            // Process each item
            foreach ($data->items as $item) {
                // Insert sale item
                $saleItemData = [
                    'sale_id' => $saleId,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal
                ];
                
                $saleItemModel->insert($saleItemData);
    
                // Update product stock
                $product = $productModel->find($item->product_id);
                if ($product) {
                    $newStock = $product['available_stock'] - $item->quantity;
                    if ($newStock < 0) {
                        throw new \Exception("Insufficient stock for product ID: {$item->product_id}");
                    }
                    
                    $productModel->update($item->product_id, [
                        'available_stock' => $newStock
                    ]);
                }
            }
    
            $db->transComplete(); // Complete transaction
    
            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }
    
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Sale recorded successfully',
                'sale_id' => $saleId
            ]);
    
        } catch (\Exception $e) {
            $db->transRollback(); // Rollback on error
            log_message('error', 'Sale Error: ' . $e->getMessage());
            
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
