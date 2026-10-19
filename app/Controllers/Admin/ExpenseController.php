<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ExpenseController extends BaseController
{
    protected $expenseModel;

    public function __construct()
    {
        parent::__construct();
        $this->expenseModel = new \App\Models\ExpenseModel();
    }

    public function index()
    {
        $data['expenses'] = $this->expenseModel->orderBy('expense_date', 'DESC')->findAll();
        return $this->render('expenses/index', $data);
    }

    public function create()
    {
        return $this->render('expenses/create');
    }

    public function store()
    {
        if (!$this->validate($this->expenseModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->expenseModel->save([
            'expense_date' => $this->request->getPost('expense_date'),
            'category'     => $this->request->getPost('category'),
            'amount'       => $this->request->getPost('amount'),
            'description'  => $this->request->getPost('description')
        ]);

        return redirect()->to('/expenses')->with('message', 'Expense added successfully');
    }

    public function edit($id)
    {
        $data['expense'] = $this->expenseModel->find($id);
        return $this->render('expenses/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->expenseModel->validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->expenseModel->update($id, [
            'expense_date' => $this->request->getPost('expense_date'),
            'category'     => $this->request->getPost('category'),
            'amount'       => $this->request->getPost('amount'),
            'description'  => $this->request->getPost('description')
        ]);

        return redirect()->to('/expenses')->with('message', 'Expense updated successfully');
    }

    public function delete($id)
    {
        $this->expenseModel->delete($id);
        return redirect()->to('/expenses')->with('message', 'Expense deleted successfully');
    }
}
