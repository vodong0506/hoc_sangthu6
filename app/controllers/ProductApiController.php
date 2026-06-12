<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ProductModel.php';

class ProductApiController
{
    private $db;
    private $product_model;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product_model = new ProductModel($this->db);
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

        switch ($method) {
            case 'GET':
                if ($id) {
                    $this->getProduct($id);
                } else {
                    $this->getProducts();
                }
                break;
            case 'POST':
                $this->createProduct();
                break;
            case 'PUT':
                $this->updateProduct($id);
                break;
            case 'DELETE':
                $this->deleteProduct($id);
                break;
            default:
                http_response_code(405);
                echo json_encode(["message" => "Method not allowed"]);
                break;
        }
    }

    /**
     * GET /api/product
     */
    private function getProducts()
    {
        $products = $this->product_model->getProducts();
        http_response_code(200);
        echo json_encode($products);
    }

    /**
     * GET /api/product/{id}
     */
    private function getProduct($id)
    {
        $product = $this->product_model->getProductById($id);
        if ($product) {
            http_response_code(200);
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Không tìm thấy sản phẩm"]);
        }
    }

    /**
     * POST /api/product
     */
    private function createProduct()
    {
        // Đọc dữ liệu từ body của request (JSON hoặc Form Data)
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }

        $name = $data['name'] ?? '';
        $description = $data['description'] ?? '';
        $price = $data['price'] ?? '';
        $category_id = (!empty($data['category_id'])) ? $data['category_id'] : null;

        // Gọi model để tạo mới
        $result = $this->product_model->addProduct($name, $description, $price, $category_id);

        if ($result === true) {
            http_response_code(201);
            echo json_encode(["message" => "Thêm sản phẩm thành công"]);
        } else if (is_array($result)) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $result]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Không thể thêm sản phẩm"]);
        }
    }

    /**
     * PUT /api/product/{id}
     */
    private function updateProduct($id)
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
            echo json_encode(["message" => "Thiếu mã sản phẩm (ID)"]);
            return;
        }

        // Kiểm tra sản phẩm tồn tại
        $existing = $this->product_model->getProductById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Sản phẩm không tồn tại"]);
            return;
        }

        $name = isset($data['name']) ? $data['name'] : $existing->name;
        $description = isset($data['description']) ? $data['description'] : $existing->description;
        $price = isset($data['price']) ? $data['price'] : $existing->price;
        $category_id = isset($data['category_id']) ? (!empty($data['category_id']) ? $data['category_id'] : null) : $existing->category_id;

        // Validation trong Model
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $errors]);
            return;
        }

        $result = $this->product_model->updateProduct($id, $name, $description, $price, $category_id);

        if ($result === true) {
            http_response_code(200);
            echo json_encode(["message" => "Cập nhật sản phẩm thành công"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Không thể cập nhật sản phẩm"]);
        }
    }

    /**
     * DELETE /api/product/{id}
     */
    private function deleteProduct($id)
    {
        if (!$id) {
            $data = json_decode(file_get_contents("php://input"), true);
            $id = $data['id'] ?? null;
        }

        if (!$id) {
            http_response_code(400);
            echo json_encode(["message" => "Thiếu mã sản phẩm (ID)"]);
            return;
        }

        // Kiểm tra sản phẩm tồn tại
        $existing = $this->product_model->getProductById($id);
        if (!$existing) {
            http_response_code(404);
            echo json_encode(["message" => "Sản phẩm không tồn tại"]);
            return;
        }

        $result = $this->product_model->deleteProduct($id);

        if ($result) {
            http_response_code(200);
            echo json_encode(["message" => "Xóa sản phẩm thành công"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Không thể xóa sản phẩm"]);
        }
    }
}
