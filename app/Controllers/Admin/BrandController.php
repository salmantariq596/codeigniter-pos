<?php

namespace App\Controllers\Admin;
use App\Models\BrandModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BrandController extends BaseController
{
    public function indexold()
    {
        $brandModel = new BrandModel();
        $data['brands'] = $brandModel->findAll();
        return $this->render('brands/index', $data);
    }

    public function index()
{
    // Get DataTables parameters from the request
    $draw = $this->request->getPost('draw') ?? 1;
    $start = $this->request->getPost('start') ?? 0;
    $length = $this->request->getPost('length') ?? 10;
    $searchValue = $this->request->getPost('search')['value'] ?? '';

    // Load the BrandModel
    $brandModel = new BrandModel();

    // Initialize the query
    $query = $brandModel->select('brands.*'); // Adjust fields if needed

    // Apply search filter
    if (!empty($searchValue)) {
        $query->like('brands.name', $searchValue)
              ->orLike('brands.description', $searchValue); // Add relevant fields for searching
    }

    // Apply pagination
    $query->limit($length, $start);

    // Fetch brands
    $brands = $query->findAll();
    $totalRecords = $brandModel->countAll(); // Total number of records
    $filteredRecords = $query->countAllResults(); // Total number of filtered records

    // Prepare data for DataTables response
    $response = [
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $brands, // Include brands in the 'data' key
    ];

    // Return JSON response
    return $this->response->setJSON($response);
}


    public function create()
    {
        return $this ->render('brands/create');
    }

    public function store()
    {
        $brandModel = new BrandModel();
        $brandModel->save([
            'name' => $this->request->getPost('name'),
        ]);
        return redirect()->to('datatable/brands');
    }

    public function edit($id)
    {
        $brandModel = new BrandModel();
        $data['brand'] = $brandModel->find($id);
        return $this ->render('brands/edit', $data);
    }

    public function update($id)
    {
        $brandModel = new BrandModel();
        $brandModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);
        return redirect()->to('/brands');
    }

    public function delete($id)
    {
        $brandModel = new BrandModel();
        $brandModel->delete($id);
        return redirect()->to('/brands');
    }

}
