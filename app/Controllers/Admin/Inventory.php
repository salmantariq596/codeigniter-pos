<?php

namespace App\Controllers\Admin;
use App\Models\InventoryModel;
use App\Models\ProductModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Inventory extends BaseController
{
    protected $inventoryModel;
    protected $productsModel;

    public function __construct()
    {
        parent::__construct();
        $this->inventoryModel = new InventoryModel();
        $this->productsModel = new ProductModel();
    }

    public function index()
    {
        // Fetch products and adjustments
        $data['products'] = $this->productsModel->findAll();
        $data['adjustments'] = $this->inventoryModel->getAllAdjustments();
        return $this->render('inventory/index', $data);
    }

    // Adjust stock
    public function adjustStock()
    {
        // Validate the form data
        $data = [
            'product_id' => $this->request->getPost('product_id'),
            'quantity' => $this->request->getPost('quantity'),
            'adjustment_type' => $this->request->getPost('adjustment_type'),
            'reason' => $this->request->getPost('reason'),
            'adjusted_by' => session()->get('user')['id'] // Assuming logged-in user's ID
        ];

        // Call the adjustStock method from the model
        $this->inventoryModel->adjustStock($data);

        // Redirect with a success message
        return redirect()->to('/inventory')->with('message', 'Stock adjustment successful');
    }

    // Edit stock adjustment
    public function editAdjustment($id)
    {
        $data['adjustment'] = $this->inventoryModel->find($id);
        $data['products'] = $this->productsModel->findAll();
        return $this->render('inventory/edit', $data);
    }

    // Update stock adjustment
    public function updateAdjustment($id)
    {
        $adjustment_type = $this->request->getPost('adjustment_type');
        $quantity = $this->request->getPost('quantity');
        $reason = $this->request->getPost('reason');

        $this->inventoryModel->updateAdjustment($id, $adjustment_type, $quantity, $reason);
        return redirect()->to('/inventory');
    }

    // Delete stock adjustment
    public function deleteAdjustment($id)
    {
        $this->inventoryModel->deleteAdjustment($id);
        return redirect()->to('/inventory');
    }

    // Add stock adjustment
    public function addAdjustment()
    {
        // Fetch the list of products for the dropdown
        $products = $this->productsModel->findAll(); // Adjust logic for fetching products if needed

        // Pass the data to the view
        return $this->render('inventory/add_adjustment', ['products' => $products]);
    }
}
