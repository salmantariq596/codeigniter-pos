<?php

namespace App\Controllers\Admin;

use App\Models\WarehouseModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WarehouseController extends BaseController
{
    protected $warehouseModel;

    public function __construct()
    {
        parent::__construct();
        $this->warehouseModel = new WarehouseModel();
    }

    public function indexold()
    {
        $data['warehouses'] = $this->warehouseModel->findAll();
        return $this->render('warehouses/index', $data);
    }

    public function index()
    {
        // Get DataTables parameters from the request
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';

        // Load the model
        $warehouseModel = $this->warehouseModel;

        // Initialize the query
        $query = $warehouseModel->select('warehouses.*');

        // Apply search filter
        if (!empty($searchValue)) {
            $query->like('warehouses.name', $searchValue)
                ->orLike('warehouses.location', $searchValue); // Adjust fields as needed
        }

        // Apply pagination
        $query->limit($length, $start);

        // Fetch warehouses
        $warehouses = $query->findAll();
        $totalRecords = $warehouseModel->countAll(); // Get the total number of records
        $filteredRecords = $query->countAllResults(); // Get the filtered number of records

        // Prepare data for DataTables response
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $warehouses, // Include the warehouses in the 'data' key
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }


    public function create()
    {
        return $this->render('warehouses/create');
    }

    public function store()
    {
        $this->warehouseModel->save([
            'name'     => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'capacity' => $this->request->getPost('capacity'),
        ]);
        return redirect()->to('datatable/warehouses')->with('success', 'Warehouse added successfully.');
    }

    public function edit($id)
    {
        $data['warehouse'] = $this->warehouseModel->find($id);
        return $this->render('warehouses/edit', $data);
    }

    public function update($id)
    {
        $this->warehouseModel->update($id, [
            'name'     => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'capacity' => $this->request->getPost('capacity'),
        ]);
        return redirect()->to('/warehouses')->with('success', 'Warehouse updated successfully.');
    }

    public function delete($id)
    {
        $this->warehouseModel->delete($id);
        return redirect()->to('/warehouses')->with('success', 'Warehouse deleted successfully.');
    }
}
