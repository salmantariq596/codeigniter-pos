<?php

namespace App\Controllers\Admin;
use App\Models\UnitModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Units extends BaseController
{
    public function indexold()
    {
        $unitModel = new UnitModel();
        $data['units'] = $unitModel->findAll();

        return $this-> render('units/index', $data);
    }

    public function index()
    {
        // Get DataTables parameters from the request
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';
    
        // Load the UnitModel
        $unitModel = new UnitModel();
    
        // Initialize the query
        $query = $unitModel->select('units.*'); // Adjust fields as needed
    
        // Apply search filter
        if (!empty($searchValue)) {
            $query->like('units.name', $searchValue)
                  ->orLike('units.description', $searchValue); // Add relevant fields for searching
        }
    
        // Apply pagination
        $query->limit($length, $start);
    
        // Fetch units
        $units = $query->findAll();
        $totalRecords = $unitModel->countAll(); // Total number of records
        $filteredRecords = $query->countAllResults(); // Total number of filtered records
    
        // Prepare data for DataTables response
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $units, // Include units in the 'data' key
        ];
    
        // Return JSON response
        return $this->response->setJSON($response);
    }
    

    public function create()
    {
        $unitModel = new UnitModel();
        $data['units'] = $unitModel->findAll();  // Get all units
    
        return $this->render('units/create', $data);  // Pass the units to the view
    }
    

    public function store()
    {
        $unitModel = new UnitModel();

        $unitModel->save([
            'name'         => $this->request->getPost('name'),
            'short_name'   => $this->request->getPost('short_name'),
            'base_unit'    => $this->request->getPost('base_unit'),
            'operate'      => $this->request->getPost('operate'),
            'operate_value'=> $this->request->getPost('operate_value'),
        ]);

        return redirect()->to('datatable/units');
    }

    public function edit($id)
    {
        $unitModel = new UnitModel();
        $data['unit'] = $unitModel->find($id);

        return $this-> render('units/edit', $data);
    }

    public function update($id)
    {
        $unitModel = new UnitModel();

        $unitModel->update($id, [
            'name'         => $this->request->getPost('name'),
            'short_name'   => $this->request->getPost('short_name'),
            'base_unit'    => $this->request->getPost('base_unit'),
            'operate'      => $this->request->getPost('operate'),
            'operate_value'=> $this->request->getPost('operate_value'),
        ]);

        return redirect()->to('/units');
    }

    public function delete($id)
    {
        $unitModel = new UnitModel();
        $unitModel->delete($id);

        return redirect()->to('/units');
    }
}
