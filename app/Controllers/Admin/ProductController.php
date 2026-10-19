<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\UnitModel;
use App\Models\BrandModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    public function index()
    {
        // Get DataTables parameters from the request
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';

        // Load the models
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $unitModel = new UnitModel();

        // Initialize the query
        $query = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');

        // Apply search filter
        if (!empty($searchValue)) {
            $query->like('products.name', $searchValue)
                ->orLike('products.description', $searchValue)
                ->orLike('categories.name', $searchValue);
        }

        // Apply pagination
        $query->limit($length, $start);

        // Fetch products
        $products = $query->findAll();
        $totalRecords = $productModel->countAll(); // Get the total number of records
        $filteredRecords = $query->countAllResults(); // Get the filtered number of records

        // Prepare data for DataTables response
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $products, // Include the products in the 'data' key
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }



    public function indexold()
    {
        // Load the models
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $unitModel = new UnitModel();
        $brandModel = new BrandModel();

        // Fetch products, categories, and units
        $products = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();
        $categories = $categoryModel->findAll();
        $units = $unitModel->findAll(); // Fetch all units

        // Pass the data to the view
        return $this->render('product/index', [
            'products' => $products,
            'categories' => $categories,
            'units' => $units, // Pass units to the view
        ]);
    }

    public function fetchCategories()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();  // Get all categories
        return $this->response->setJSON($categories);  // Return JSON response
    }

    // Method to fetch products by category
    public function fetchProductsByCategory($categoryId)
    {
        $productModel = new ProductModel();
        $products = $productModel->where('category_id', $categoryId)->findAll();  // Get products by category ID

        // Adding image URL and barcode to products data
        foreach ($products as &$product) {
            // Add the full URL for the product image
            $product['image_url'] = base_url('uploads/' . $product['img']);

            // Add barcode to the product data
            $product['product_barcode'] = $product['product_barcode'];
        }

        return $this->response->setJSON($products);  // Return JSON response
    }



    public function datatable()
    {
        // Load the models
        $productModel = new ProductModel();

        // Get all the products with categories
        $products = $productModel->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();

        // Format data as needed for DataTable (return as JSON)
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product['id'],
                'image' => base_url('uploads/' . $product['img']),
                'name' => $product['name'],
                'brand' => $product['brand'],
                'category' => $product['category_name'],
                'price' => $product['price'],
                'barcode' => $product['product_barcode'],
                'unit' => $product['product_unit'],
                'description' => $product['description'],
                'stock' => $product['available_stock'],
                'actions' => '<a href="' . site_url('product/edit/' . $product['id']) . '">Edit</a> | <a href="' . site_url('product/delete/' . $product['id']) . '">Delete</a>'
            ];
        }

        // Return the data in JSON format
        return $this->response->setJSON(['data' => $data]);
    }

    public function add()
    {
        $categoryModel = new CategoryModel();
        $unitModel = new UnitModel();
        $brandModel = new BrandModel();

        $data = [
            'categories' => $categoryModel->findAll(), // Fetch all categories
            'units' => $unitModel->findAll(), // Fetch all units
            'brands' => $brandModel->findAll(), // Fetch all units
        ];

        return $this->render('product/add', $data); // Pass categories and units to the add view
    }


    public function store()
    {
        $model = new ProductModel();
        $data = [
            'name' => $this->request->getPost('name'),
            'brand' => $this->request->getPost('brand'),
            'tax' => $this->request->getPost('tax'),
            'tax_type' => $this->request->getPost('tax_type'),
            'product_type' => $this->request->getPost('product_type'),
            'product_unit' => $this->request->getPost('product_unit'),
            'purchase_unit' => $this->request->getPost('purchase_unit'),
            'sale_unit' => $this->request->getPost('sale_unit'),
            'stock_alert' => $this->request->getPost('stock_alert'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $this->request->getPost('price'),
            'product_barcode' => $this->request->getPost('product_barcode'),
            'description' => $this->request->getPost('description'),
            'available_stock' => $this->request->getPost('available_stock'),
        ];

        // Validate input
        if (!$this->validate([
            'product_unit' => 'required|integer',
            'purchase_unit' => 'required|integer',
            'sale_unit' => 'required|integer',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Invalid unit selection.');
        }

        // Handle image upload
        if ($this->request->getFile('img')->isValid() && !$this->request->getFile('img')->hasMoved()) {
            $img = $this->request->getFile('img');
            if (in_array($img->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'uploads', $newName);
                $data['img'] = $newName;
            }
        }

        // Save to the database
        $model->save($data);

        // Redirect to the product list page
        return redirect()->to('datatable/all_products');
    }

    public function getUnitDetails()
    {
        if ($this->request->isAJAX()) {
            $unitId = $this->request->getPost('unit_id');

            // Load your UnitModel to fetch unit details
            $unitModel = new UnitModel();
            $unit = $unitModel->find($unitId);

            if ($unit) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => [
                        'name' => $unit['name'],
                        'base_unit' => $unit['base_unit']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unit not found!'
                ]);
            }
        }

        return redirect()->to('/');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();

        // Fetch the product data by ID
        $data['product'] = $productModel->find($id);

        // Fetch all categories
        $data['categories'] = $categoryModel->findAll();

        // Check if the product exists
        if (!$data['product']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Pass the product and categories data to the view
        return $this->render('product/edit', $data);
    }

    public function update($id)
    {
        $model = new ProductModel();

        // Fetch the existing product data
        $existingProduct = $model->find($id);
        if (!$existingProduct) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product with ID $id not found.");
        }

        // Collect data from the request
        $data = [
            'name' => $this->request->getPost('name'),
            'brand' => $this->request->getPost('brand'),
            'category_id' => $this->request->getPost('category_id'),
            'price' => $this->request->getPost('price'),
            'product_barcode' => $this->request->getPost('product_barcode'),
            'description' => $this->request->getPost('description'),
            'available_stock' => $this->request->getPost('available_stock'),
        ];

        // Handle image upload (if new image is uploaded)
        $img = $this->request->getFile('img');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Validate the file type and size if needed
            if (in_array($img->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                $newName = $img->getRandomName();
                $img->move(WRITEPATH . 'uploads', $newName);
                $data['img'] = $newName;
            } else {
                // Handle invalid file type
                return redirect()->back()->with('error', 'Invalid file type. Only JPG, PNG, and GIF are allowed.');
            }
        } else {
            // Keep the existing image if no new image is uploaded
            $data['img'] = $existingProduct['img'];
        }

        // Update the product in the database
        $model->update($id, $data);

        // Redirect to the product list page with a success message
        return redirect()->to('/product')->with('message', 'Product updated successfully!');
    }

    // Show the form to add a category
    public function addCategoryform()
    {
        return $this->render('product/add_categories');
    }

    // Handle adding a category to the database
    public function addCategory()
    {
        // Get input data
        $categoryName = $this->request->getPost('category_name');

        // Create CategoryModel instance
        $categoryModel = new CategoryModel();

        // Save the category
        if ($categoryModel->save(['name' => $categoryName])) {
            return redirect()->back()->with('message', 'Category added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add category.');
        }
    }

    public function allCategories()
    {
        // Get DataTables parameters from the request
        $draw = $this->request->getPost('draw') ?? 1;
        $start = $this->request->getPost('start') ?? 0;
        $length = $this->request->getPost('length') ?? 10;
        $searchValue = $this->request->getPost('search')['value'] ?? '';

        // Load the model
        $categoryModel = new CategoryModel();

        // Initialize the query
        $query = $categoryModel->select('*');

        // Apply search filter
        if (!empty($searchValue)) {
            $query->like('name', $searchValue); // Apply search filter for category name
        }

        // Apply pagination
        $query->limit($length, $start);

        // Fetch categories
        $categories = $query->findAll();
        $totalRecords = $categoryModel->countAll(); // Get the total number of records
        $filteredRecords = $query->countAllResults(); // Get the filtered number of records

        // Prepare data for DataTables response
        $response = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $categories, // Include the categories in the 'data' key
        ];

        // Return JSON response
        return $this->response->setJSON($response);
    }


    // Display all categories
    public function allCategoriesold()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        return $this->render('product/all_categories', ['categories' => $categories]);
    }

    public function delete($id)
    {
        $productModel = new ProductModel();

        if ($productModel->delete($id)) {
            session()->setFlashdata('message', 'Product deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete product.');
        }

        return redirect()->to('/product'); // Redirect after product deletion
    }


    public function deleteCategory($id)
    {
        $categoryModel = new CategoryModel();

        if ($categoryModel->delete($id)) {
            session()->setFlashdata('message', 'Category deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete category.');
        }

        return redirect()->to('/all_categories');
    }
}
