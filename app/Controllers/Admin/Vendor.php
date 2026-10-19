<?php

namespace App\Controllers\Admin;
use App\Models\VendorModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Vendor extends BaseController
{
    protected $vendorModel;

    public function __construct()
    {
        parent::__construct();
        $this->vendorModel = new VendorModel();
    }

    public function indexold()
    {
        $data['vendors'] = $this->vendorModel->findAll();
        return $this->render('vendor/index', $data);
    }

    public function index()
{
    // Get DataTables parameters from the request
    $draw = $this->request->getPost('draw') ?? 1;
    $start = $this->request->getPost('start') ?? 0;
    $length = $this->request->getPost('length') ?? 10;
    $searchValue = $this->request->getPost('search')['value'] ?? '';

    // Initialize the query
    $query = $this->vendorModel;

    // Apply search filter
    if (!empty($searchValue)) {
        $query->like('name', $searchValue)
              ->orLike('email', $searchValue)
              ->orLike('contact', $searchValue); // Add fields to search as needed
    }

    // Apply pagination
    $query->limit($length, $start);

    // Fetch vendors
    $vendors = $query->findAll();
    $totalRecords = $this->vendorModel->countAll(); // Total number of records
    $filteredRecords = $query->countAllResults(); // Total number of filtered records

    // Prepare data for DataTables response
    $response = [
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $vendors, // Include vendors in the 'data' key
    ];

    // Return JSON response
    return $this->response->setJSON($response);
}


    public function add()
    {
        return $this->render('vendor/add');
    }

    public function save()
    {
        $data = [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        $this->vendorModel->insert($data);
        return redirect()->to('datatable/vendor')->with('success', 'Vendor added successfully!');
    }

    public function edit($id)
    {
        $vendor = $this->vendorModel->find($id);
        if (!$vendor) {
            return redirect()->to('/vendor')->with('error', 'Vendor not found.');
        }

        return $this->render('vendor/edit', ['vendor' => $vendor]);
    }

    public function update($id)
    {
        $this->vendorModel->update($id, [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/vendor')->with('success', 'Vendor updated successfully.');
    }

    public function delete($id)
    {
        $vendor = $this->vendorModel->find($id);
        if ($vendor) {
            $this->vendorModel->delete($id);
            return redirect()->to('/vendor')->with('success', 'Vendor deleted successfully.');
        }

        return redirect()->to('/vendor')->with('error', 'Vendor not found.');
    }
}
