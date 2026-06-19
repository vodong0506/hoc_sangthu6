<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../utils/JWTHandler.php';

class ProductController
{
    private $db;
    private $product_model;
    private $category_model;
    private $jwtHandler;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product_model = new ProductModel($this->db);
        $this->category_model = new CategoryModel($this->db);
        $this->jwtHandler = new JWTHandler();
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
        if (!$this->authenticate()) {
            http_response_code(401);
            echo json_encode(["message" => "Unauthorized"]);
            return;
        }
        header('Content-Type: application/json');
        $products = $this->product_model->getProducts();
        echo json_encode($products);
    }

    // API - Lấy sản phẩm theo ID (JSON)
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

    // ===== GIỎ HÀNG & ĐẶT HÀNG =====

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($id)
    {
        $product = $this->product_model->getProductById($id);
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm.';
            header('Location: ' . BASE_URL . '/product');
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
                'description' => $product->description
            ];
        }

        $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng';
        header('Location: ' . BASE_URL . '/product/cart');
        exit;
    }

    // Hiển thị giỏ hàng
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        require_once __DIR__ . '/../view/product/cart.php';
    }

    // Cập nhật số lượng trong giỏ hàng
    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = (int) ($_POST['quantity'] ?? 0);

            if ($product_id && isset($_SESSION['cart'][$product_id])) {
                if ($quantity <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                    $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
                } else {
                    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
                    $_SESSION['success'] = 'Đã cập nhật giỏ hàng';
                }
            }
        }

        header('Location: ' . BASE_URL . '/product/cart');
        exit;
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        }

        header('Location: ' . BASE_URL . '/product/cart');
        exit;
    }

    // Hiển thị form thanh toán
    public function checkout()
    {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['error'] = 'Giỏ hàng trống. Vui lòng thêm sản phẩm.';
            header('Location: ' . BASE_URL . '/product/cart');
            exit;
        }

        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        require_once __DIR__ . '/../view/product/checkout.php';
    }

    // Xử lý thanh toán (tạo đơn hàng)
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/product/checkout');
            exit;
        }

        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        // Validation
        $errors = [];
        if (empty($name))
            $errors['name'] = 'Tên không được để trống';
        if (empty($phone))
            $errors['phone'] = 'Số điện thoại không được để trống';
        if (empty($address))
            $errors['address'] = 'Địa chỉ không được để trống';

        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $errors['cart'] = 'Giỏ hàng trống';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_URL . '/product/checkout');
            exit;
        }

        try {
            // Bắt đầu transaction
            $this->db->beginTransaction();

            // Lưu thông tin đơn hàng
            $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', htmlspecialchars(strip_tags($name)));
            $stmt->bindParam(':phone', htmlspecialchars(strip_tags($phone)));
            $stmt->bindParam(':address', htmlspecialchars(strip_tags($address)));
            $stmt->execute();

            $order_id = $this->db->lastInsertId();

            // Lưu chi tiết đơn hàng
            $cart = $_SESSION['cart'];
            foreach ($cart as $product_id => $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                         VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $item['quantity'], PDO::PARAM_INT);
                $stmt->bindParam(':price', $item['price']);
                $stmt->execute();
            }

            // Commit transaction
            $this->db->commit();

            // Xóa giỏ hàng
            unset($_SESSION['cart']);
            $_SESSION['order_id'] = $order_id;
            $_SESSION['success'] = 'Đặt hàng thành công!';

            header('Location: ' . BASE_URL . '/product/orderConfirmation');
            exit;

        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->db->rollBack();
            $_SESSION['error'] = 'Đã xảy ra lỗi: ' . $e->getMessage();
            header('Location: ' . BASE_URL . '/product/checkout');
            exit;
        }
    }

    // Hiển thị xác nhận đơn hàng
    public function orderConfirmation()
    {
        if (!isset($_SESSION['order_id'])) {
            header('Location: ' . BASE_URL . '/product');
            exit;
        }

        $order_id = $_SESSION['order_id'];

        // Lấy thông tin đơn hàng
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $order_id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_OBJ);

        // Lấy chi tiết đơn hàng
        $query = "SELECT od.*, p.name as product_name FROM order_details od
                 LEFT JOIN product p ON od.product_id = p.id
                 WHERE od.order_id = :order_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $order_details = $stmt->fetchAll(PDO::FETCH_OBJ);

        require_once __DIR__ . '/../view/product/orderConfirmation.php';
    }
}
?>