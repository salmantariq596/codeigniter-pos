<?php

namespace App\Controllers;

use App\Models\DatatableConfigModel;

class DatatableController extends BaseController
{
    protected $datatableModel;

    public function __construct()
    {
        $this->datatableModel = new DatatableConfigModel();
    }

    public function listAllUsers($tableName)
    {
        // Fetch datatable configuration by table name
        $config = $this->datatableModel->getConfigByTableName($tableName);

        if (!$config) {
            return $this->render('errors/html/error_404', ['message' => 'Datatable configuration not found.']);
        }

        $data = [
            'tableName' => $tableName,
            'tableTitle' => $config['table_title'],
            'apiEndpoint' => $config['api_endpoint'],
            'columns' => json_decode($config['columns'], true), // Decode JSON columns
            'styles' => $this->getStandardStyles(),
        ];

        return $this->render('layout/datatable', $data);
    }


    
    public function listallproducts() {}



    private function getStandardStyles()
    {
        return [
            // Basic table classes
            'tableClass' => 'table table-bordered table-hover',
            'headerClass' => 'bg-primary text-white',

            // Color scheme
            'colors' => [
                'primary' => '#2563eb',
                'secondary' => '#f3f4f6',
                'text' => '#1f2937',
                'border' => '#e5e7eb',
                'hover' => '#f8fafc',
                'shadow' => 'rgba(0, 0, 0, 0.1)'
            ],

            // Container styles
            'container' => [
                'maxWidth' => '1500px',
                'padding' => '25px',
                'borderRadius' => '12px',
                'background' => 'white'
            ],

            // Typography
            'typography' => [
                'titleSize' => '24px',
                'titleWeight' => '600',
                'titleMargin' => '25px',
                'fontFamily' => 'system-ui, -apple-system, calibri'
            ],

            // Animations
            'animations' => [
                'enable' => true,
                'duration' => '0.5s',
                'type' => 'ease-in'
            ]
        ];
    }
}
