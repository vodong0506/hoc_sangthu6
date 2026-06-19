<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../utils/JWTHandler.php';

class CategoryApiController
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

    /**
     * Điều hướng các yêu cầu API dựa trên phương thức HTTP
     */
    public function handleRequest($id = null)
    {
        // Thiết lập headers cho RESTful API
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        // Xác thực JWT token
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            exit;
        }

        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getCategory($id);
                } else {
                    $this->getCategories();
                }
                break;
            case 'POST':
                $this->createCategory();
                break;
            case 'PUT':
                $this->updateCategory($id);
                break;
            case 'DELETE':
                $this->deleteCategory($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
    }

    /**
     * Xác thực JWT Token từ header Authorization
     */
    private function authenticate()
    {
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
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                return $decoded ? true : false;
            }
        }
        return false;
    }

    /**
     * GET /api/category
     */
    private function getCategories()
    {
        $categories = $this->category_model->getCategories();
        http_response_code(200);
        echo json_encode($categories);
    }

    /**
     * GET /api/category/{id}
     */
    private function getCategory($id)
    {
        $category = $this->category_model->getCategoryById($id);
        if ($category) {
            http_response_code(200);
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Không tìm thấy danh mục"]);
        }
    }

    /**
     * POST /api/category
     */
    private function createCategory()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';

        $result = $this->category_model->addCategory($name, $description);

        if ($result === true) {
            http_response_code(201);
            echo json_encode(["message" => "Thêm danh mục thành công"]);
        } else if (is_array($result)) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $result]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Không thể thêm danh mục"]);
        }
    }

    /**
     * PUT /api/category/{id}
     */
    private function updateCategory($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }

        if (!$id) {
            $id = $data['id'] ?? null;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Thiếu mã danh mục (ID)"]);
            return;
        }

        // Kiểm tra danh mục tồn tại
        $existing = $this->category_model->getCategoryById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Danh mục không tồn tại"]);
            return;
        }

        $name = isset($data['name']) ? $data['name'] : $existing->name;
        $description = isset($data['description']) ? $data['description'] : $existing->description;

        // Validation
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống';
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $errors]);
            return;
        }

        $result = $this->category_model->updateCategory($id, $name, $description);

        if ($result === true) {
            http_response_code(200);
            echo json_encode(["message" => "Cập nhật danh mục thành công"]);
        } else if (is_array($result)) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $result]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Không thể cập nhật danh mục"]);
        }
    }

    /**
     * DELETE /api/category/{id}
     */
    private function deleteCategory($id)
    {
        if (!$id) {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'] ?? null;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Thiếu mã danh mục (ID)"]);
            return;
        }

        // Kiểm tra danh mục tồn tại
        $existing = $this->category_model->getCategoryById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Danh mục không tồn tại"]);
            return;
        }

        $result = $this->category_model->deleteCategory($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Xóa danh mục thành công"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Không thể xóa danh mục"]);
        }
    }
}
