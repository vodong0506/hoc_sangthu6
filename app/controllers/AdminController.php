<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class AdminController
{
    private $db;
    private $product_model;
    private $category_model;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product_model = new ProductModel($this->db);
        $this->category_model = new CategoryModel($this->db);
    }

    public function index()
    {
        $products = $this->product_model->getProducts();
        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/admin/dashboard.php';
    }

    // --- Product CRUD ---
    public function productCreate()
    {
        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/admin/product_add.php';
    }

    public function productStore()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Invalid request');
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $price = $_POST['price'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $image_file = $_FILES['image'] ?? null;

        $result = $this->product_model->addProduct($name, $description, $price, $category_id, $image_file);

        if (is_array($result)) {
            $categories = $this->category_model->getCategories();
            $errors = $result;
            require_once __DIR__ . '/../view/admin/product_add.php';
        } else if ($result === true) {
            $_SESSION['success'] = 'Thêm sản phẩm thành công';
            header('Location: ' . BASE_URL . '/admin');
            exit;
        } else {
            $categories = $this->category_model->getCategories();
            $errors = ['general' => 'Không thể thêm sản phẩm'];
            require_once __DIR__ . '/../view/admin/product_add.php';
        }
    }

    public function productEdit($id = null)
    {
        if (!$id) {
            die('Product ID not found');
        }

        $product = $this->product_model->getProductById($id);
        if (!$product) {
            die('Product not found');
        }

        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/admin/product_edit.php';
    }

    public function productUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image_file = !empty($_FILES['image']['name']) ? $_FILES['image'] : null;

            $result = $this->product_model->updateProduct($id, $name, $description, $price, $category_id, $image_file);

            if ($result === true) {
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                header('Location: ' . BASE_URL . '/admin');
                exit;
            } else {
                $product = $this->product_model->getProductById($id);
                $categories = $this->category_model->getCategories();
                $errors = is_array($result) ? $result : ['general' => 'Không thể cập nhật sản phẩm'];
                require_once __DIR__ . '/../view/admin/product_edit.php';
            }
        }
    }

    public function productDelete($id = null)
    {
        if (!$id) {
            die('Product ID not found');
        }

        if ($this->product_model->deleteProduct($id)) {
            $_SESSION['success'] = 'Xóa sản phẩm thành công';
            header('Location: ' . BASE_URL . '/admin');
            exit;
        } else {
            die('Không thể xóa sản phẩm');
        }
    }

    // --- Category CRUD ---
    public function categoryCreate()
    {
        require_once __DIR__ . '/../view/admin/category_add.php';
    }

    public function categoryStore()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Invalid request');
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        $result = $this->category_model->addCategory($name, $description);

        if (is_array($result)) {
            $errors = $result;
            require_once __DIR__ . '/../view/admin/category_add.php';
        } else if ($result === true) {
            $_SESSION['success'] = 'Thêm danh mục thành công';
            header('Location: ' . BASE_URL . '/admin');
            exit;
        } else {
            $errors = ['general' => 'Không thể thêm danh mục'];
            require_once __DIR__ . '/../view/admin/category_add.php';
        }
    }

    public function categoryEdit($id = null)
    {
        if (!$id) {
            die('Category ID not found');
        }

        $category = $this->category_model->getCategoryById($id);
        if (!$category) {
            die('Category not found');
        }

        require_once __DIR__ . '/../view/admin/category_edit.php';
    }

    public function categoryUpdate()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Invalid request');
        }

        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        $result = $this->category_model->updateCategory($id, $name, $description);

        if (is_array($result)) {
            $category = $this->category_model->getCategoryById($id);
            $errors = $result;
            require_once __DIR__ . '/../view/admin/category_edit.php';
        } else if ($result === true) {
            $_SESSION['success'] = 'Cập nhật danh mục thành công';
            header('Location: ' . BASE_URL . '/admin');
            exit;
        } else {
            $category = $this->category_model->getCategoryById($id);
            $errors = ['general' => 'Không thể cập nhật danh mục'];
            require_once __DIR__ . '/../view/admin/category_edit.php';
        }
    }

    public function categoryDelete($id = null)
    {
        if (!$id) {
            die('Category ID not found');
        }

        $result = $this->category_model->deleteCategory($id);

        if ($result) {
            $_SESSION['success'] = 'Xóa danh mục thành công';
            header('Location: ' . BASE_URL . '/admin');
            exit;
        } else {
            die('Không thể xóa danh mục');
        }
    }
}
