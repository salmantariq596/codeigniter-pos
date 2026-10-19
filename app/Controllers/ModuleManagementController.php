<?php

namespace App\Controllers;
use App\Controllers\BaseController;

// use CodeIgniter\Controller;

class ModuleManagementController extends BaseController
{
   
    public function index()
    {
        $db = \Config\Database::connect();
        $modules = $db->table('modules')->get()->getResult();

        return $this->render('modules/index', ['modules' => $modules]);
    }

    public function uploadModule()
    {
        $file = $this->request->getFile('module_zip');

        if ($file->isValid() && !$file->hasMoved()) {
            // Generate a random name and move the file
            $file->move(WRITEPATH . 'uploads');
            $zipPath = WRITEPATH . 'uploads/' . $file->getName();

            // Open and extract the ZIP file
            $zip = new \ZipArchive;
            if ($zip->open($zipPath) === true) {
                $extractPath = ROOTPATH . 'modules/';
                if (!is_dir($extractPath)) {
                    mkdir($extractPath, 0755, true);
                }
                $zip->extractTo($extractPath);
                $zip->close();

                // Save module info in the database
                $moduleName = basename($file->getClientName(), '.zip');
                $this->saveModuleInfo($moduleName);

                return redirect()->back()->with('message', 'Module installed successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to extract the module ZIP file.');
            }
        }

        return redirect()->back()->with('error', 'Failed to install module. Ensure the file is valid.');
    }

    private function saveModuleInfo($moduleName)
    {
        $db = \Config\Database::connect();
        $db->table('modules')->insert([
            'name' => $moduleName,
            'status' => 'inactive',
        ]);
    }

    public function toggleStatus($id)
    {
        $db = \Config\Database::connect();
        $module = $db->table('modules')->where('id', $id)->get()->getRow();

        if ($module) {
            $newStatus = $module->status === 'active' ? 'inactive' : 'active';
            $db->table('modules')->where('id', $id)->update(['status' => $newStatus]);

            return redirect()->back()->with('message', "Module {$module->name} status updated to {$newStatus}.");
        }

        return redirect()->back()->with('error', 'Module not found.');
    }
}
