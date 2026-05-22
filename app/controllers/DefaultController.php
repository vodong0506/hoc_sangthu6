<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class DefaultController
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

    // Hiển thị trang chủ
    public function index()
    {
        $products = $this->product_model->getProducts();
        $categories = $this->category_model->getCategories();
        require_once __DIR__ . '/../view/home.php';
    }

    // Hiển thị thông tin về
    public function about()
    {
        require_once __DIR__ . '/../view/about.php';
    }

    // Hiển thị trang liên hệ
    public function contact()
    {
        require_once __DIR__ . '/../view/contact.php';
    }

    // Xử lý gửi form liên hệ
    public function sendContact()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            die('Invalid request');
        }

        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';

        // Validate
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên không được để trống';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }
        if (empty($subject)) {
            $errors['subject'] = 'Chủ đề không được để trống';
        }
        if (empty($message)) {
            $errors['message'] = 'Nội dung không được để trống';
        }

        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . '/default/contact');
            exit;
        }

        // TODO: Gửi email hoặc lưu vào database
        $_SESSION['success'] = 'Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm';
        header('Location: ' . BASE_URL . '/default/contact');
        exit;
    }

    // API - Lấy thống kê (JSON)
    public function statsApi()
    {
        header('Content-Type: application/json');

        $products = $this->product_model->getProducts();
        $categories = $this->category_model->getCategories();

        $stats = [
            'total_products' => count($products),
            'total_categories' => count($categories),
            'timestamp' => date('Y-m-d H:i:s')
        ];

        echo json_encode($stats);
    }
}
?>