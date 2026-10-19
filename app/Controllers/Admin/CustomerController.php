<?php

namespace App\Controllers\Admin;

use App\Models\CustomerModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerController extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        parent::__construct();
        $this->customerModel = new CustomerModel();
    }

    // List all customers
    public function indexold()
    {
        $data['customers'] = $this->customerModel->findAll();
        return $this->render('customers/index', $data);
    
    }

    public function index()
{
    // Get DataTables parameters from the request
    $draw = $this->request->getPost('draw') ?? 1;
    $start = $this->request->getPost('start') ?? 0;
    $length = $this->request->getPost('length') ?? 10;
    $searchValue = $this->request->getPost('search')['value'] ?? '';

    // Initialize the query
    $query = $this->customerModel;

    // Apply search filter
    if (!empty($searchValue)) {
        $query->like('name', $searchValue)
              ->orLike('email', $searchValue) // Example: search by name or email
              ->orLike('phone', $searchValue); // Example: search by phone
    }

    // Get the total number of records
    $totalRecords = $this->customerModel->countAll();

    // Get the filtered number of records
    $filteredRecords = $query->countAllResults(false); // Prevents query reset

    // Apply pagination
    $query->limit($length, $start);

    // Fetch the customers
    $customers = $query->findAll();

    // Prepare data for DataTables response
    $response = [
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $customers, // Include the customers in the 'data' key
    ];

    // Return JSON response
    return $this->response->setJSON($response);
}



    // Show form to add a new customer
    public function create()
    {
        return $this->render('customers/create');
    }

    // Save a new customer
    public function store()
    {
        $this->customerModel->save($this->request->getPost());
        return redirect()->to('datatable/customers');
    }

    // Show form to edit a customer
    public function edit($id)
    {
        $data['customer'] = $this->customerModel->find($id);
        return $this->render('customers/edit', $data);
    }

    // Update customer details
    public function update($id)
    {
        $this->customerModel->update($id, $this->request->getPost());
        return redirect()->to('/customers');
    }

    // Delete a customer
    public function delete($id)
    {
        $this->customerModel->delete($id);
        return redirect()->to('/customers');
    }
}
