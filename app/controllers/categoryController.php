<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../utils/JWTHandler.php';

class CategoryController
{
    private $db;
    private $category_model;
    private $jwtHandler;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->category_model = new CategoryModel($this->db);
        $this->jwtHandler = new JWTHandler();
    }

    // Hiển thị danh sách danh mục
    public function index()
    {
        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/categories/list.php';
    }

    // Hiển thị form thêm danh mục
    public function create()
    {
        require_once __DIR__ . '/../view/categories/create.php';
    }

    // Xử lý thêm danh mục
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Invalid request');
        }

        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        $result = $this->category_model->addCategory($name, $description);

        if (is_array($result)) {
            // Có lỗi validation
            $errors = $result;
            require_once __DIR__ . '/../view/categories/create.php';
        } else if ($result === true) {
            // Thêm thành công
            header('Location: ' . BASE_URL . '/category');
            exit;
        } else {
            // Lỗi khác
            $errors = ['general' => 'Không thể thêm danh mục'];
            require_once __DIR__ . '/../view/categories/create.php';
        }
    }

    // Hiển thị form sửa danh mục
    public function edit()
    {
        $url = $_GET['url'] ?? '';
        $url = explode('/', trim($url, '/'));
        $id = $url[2] ?? null;

        if (!$id) {
            die('Category ID not found');
        }

        $category = $this->category_model->getCategoryById($id);
        if (!$category) {
            die('Category not found');
        }

        require_once __DIR__ . '/../view/categories/edit.php';
    }

    // Xử lý cập nhật danh mục
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Invalid request');
        }

        $id = $_POST['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        $result = $this->category_model->updateCategory($id, $name, $description);

        if (is_array($result)) {
            // Có lỗi validation
            $category = $this->category_model->getCategoryById($id);
            $errors = $result;
            require_once __DIR__ . '/../view/categories/edit.php';
        } else if ($result === true) {
            // Cập nhật thành công
            header('Location: ' . BASE_URL . '/category');
            exit;
        } else {
            // Lỗi khác
            $category = $this->category_model->getCategoryById($id);
            $errors = ['general' => 'Không thể cập nhật danh mục'];
            require_once __DIR__ . '/../view/categories/edit.php';
        }
    }

    // Xử lý xóa danh mục
    public function delete()
    {
        $url = $_GET['url'] ?? '';
        $url = explode('/', trim($url, '/'));
        $id = $url[2] ?? null;

        if (!$id) {
            die('Category ID not found');
        }

        $result = $this->category_model->deleteCategory($id);

        if ($result) {
            header('Location: ' . BASE_URL . '/category');
            exit;
        } else {
            die('Không thể xóa danh mục');
        }
    }

    // API - Lấy tất cả danh mục (JSON)
    public function listApi()
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }
        header('Content-Type: application/json');
        $categories = $this->category_model->getCategories();
        echo json_encode($categories);
    }

    // API - Lấy danh mục theo ID (JSON)
    public function getApi()
    {
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }
        header('Content-Type: application/json');
        $url = $_GET['url'] ?? '';
        $url = explode('/', trim($url, '/'));
        $id = $url[2] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Category ID not found']);
            return;
        }

        $category = $this->category_model->getCategoryById($id);
        if (!$category) {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
            return;
        }

        echo json_encode($category);
    }

    /**
     * Xác thực JWT Token từ header Authorization
     */
    private function authenticate()
    {
        $jwt = null;

        // 1. Đọc token từ cookie trước
        if (isset($_COOKIE['token'])) {
            $jwt = $_COOKIE['token'];
        }

        // 2. Nếu không có trong cookie, đọc từ Bearer token trong Header
        if (!$jwt) {
            $headers = [];
            if (function_exists('apache_request_headers')) {
                $headers = apache_request_headers();
            } elseif (function_exists('getallheaders')) {
                $headers = getallheaders();
            }

            $authHeader = null;
            if (isset($headers['Authorization'])) {
                $authHeader = $headers['Authorization'];
            } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $authHeader = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            }

            if ($authHeader) {
                $arr = explode(" ", $authHeader);
                $jwt = $arr[1] ?? null;
            }
        }

        // 3. Giải mã và xác thực token
        if ($jwt) {
            $decoded = $this->jwtHandler->decode($jwt);
            return $decoded ? true : false;
        }

        return false;
    }
}
?>