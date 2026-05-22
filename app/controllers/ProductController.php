<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ProductController
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

    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $products = $this->product_model->getProducts();
        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/product/list.php';
    }

    // Hiển thị form thêm sản phẩm
    public function create()
    {
        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/product/add.php';
    }

    // Xử lý thêm sản phẩm
    public function store()
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
            // Có lỗi validation
            $categories = $this->category_model->getCategories();
            $errors = $result;
            require_once __DIR__ . '/../view/product/add.php';
        } else if ($result === true) {
            // Thêm thành công
            header('Location: ' . BASE_URL . '/product');
            exit;
        } else {
            // Lỗi khác
            $categories = $this->category_model->getCategories();
            $errors = ['general' => 'Không thể thêm sản phẩm'];
            require_once __DIR__ . '/../view/product/add.php';
        }
    }

    // Hiển thị form sửa sản phẩm
    public function edit()
    {
        $url = $_GET['url'] ?? '';
        $url = explode('/', trim($url, '/'));
        $id = $url[2] ?? null;

        if (!$id) {
            die('Product ID not found');
        }

        $product = $this->product_model->getProductById($id);
        if (!$product) {
            die('Product not found');
        }

        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/product/edit.php';
    }

    // Xử lý cập nhật sản phẩm
    public function update()
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
                header('Location: ' . BASE_URL . '/product');
                exit;
            } else {
                $product = $this->product_model->getProductById($id);
                $categories = $this->category_model->getCategories();
                $errors = is_array($result) ? $result : ['general' => 'Không thể cập nhật sản phẩm'];
                require_once __DIR__ . '/../view/product/edit.php';
            }
        }
    }

    public function delete($id)
    {
        if ($this->product_model->deleteProduct($id)) {
            header('Location: ' . BASE_URL . '/product');
            exit;
        } else {
            echo 'Không thể xóa sản phẩm';
        }
    }

    // Hiển thị chi tiết sản phẩm
    public function show()
    {
        $url = $_GET['url'] ?? '';
        $url = explode('/', trim($url, '/'));
        $id = $url[2] ?? null;

        if (!$id) {
            die('Product ID not found');
        }

        $product = $this->product_model->getProductById($id);
        if (!$product) {
            die('Product not found');
        }

        require_once __DIR__ . '/../view/product/show.php';
    }

    // API - Lấy tất cả sản phẩm (JSON)
    public function listApi()
    {
        header('Content-Type: application/json');
        $products = $this->product_model->getProducts();
        echo json_encode($products);
    }

    // API - Lấy sản phẩm theo ID (JSON)
    public function getApi()
    {
        header('Content-Type: application/json');
        $url = $_GET['url'] ?? '';
        $url = explode('/', trim($url, '/'));
        $id = $url[2] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Product ID not found']);
            return;
        }

        $product = $this->product_model->getProductById($id);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
            return;
        }

        echo json_encode($product);
    }
}
?>