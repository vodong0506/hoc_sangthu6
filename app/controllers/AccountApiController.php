<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AccountModel.php';

class AccountApiController
{
    private $db;
    private $accountModel;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    /**
     * Điều hướng các yêu cầu API tài khoản dựa trên action và method
     */
    public function handleRequest($action)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        if ($method !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed. Only POST is accepted."]);
            exit;
        }

        switch (strtolower($action)) {
            case 'register':
                $this->register();
                break;
            case 'login':
                $this->login();
                break;
            default:
                http_response_code(404);
                echo json_encode(["message" => "Action API không tồn tại"]);
                break;
        }
    }

    /**
     * POST /api/account/register
     */
    private function register()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }

        $username = $data['username'] ?? '';
        $fullName = $data['fullname'] ?? '';
        $password = $data['password'] ?? '';
        $confirmPassword = $data['confirmpassword'] ?? '';
        $role = $data['role'] ?? 'user';

        $errors = [];
        if (empty($username)) {
            $errors['username'] = "Vui lòng nhập username!";
        }
        if (empty($fullName)) {
            $errors['fullname'] = "Vui lòng nhập fullname!";
        }
        if (empty($password)) {
            $errors['password'] = "Vui lòng nhập password!";
        }
        if ($password !== $confirmPassword) {
            $errors['confirmpassword'] = "Mật khẩu và xác nhận chưa khớp!";
        }
        if (!in_array($role, ['admin', 'user'])) {
            $role = 'user';
        }

        if (empty($errors)) {
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['username'] = "Tài khoản này đã được đăng ký!";
            }
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $errors]);
            return;
        }

        $result = $this->accountModel->save($username, $fullName, $password, $role);
        if ($result) {
            http_response_code(201);
            echo json_encode(["message" => "Đăng ký tài khoản thành công"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Đăng ký tài khoản thất bại, vui lòng thử lại."]);
        }
    }

    /**
     * POST /api/account/login
     */
    private function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            $data = $_POST;
        }

        $username = $data['username'] ?? '';
        $password = $data['password'] ?? '';

        $errors = [];
        if (empty($username)) {
            $errors['username'] = "Vui lòng nhập username!";
        }
        if (empty($password)) {
            $errors['password'] = "Vui lòng nhập mật khẩu!";
        }

        if (count($errors) > 0) {
            http_response_code(400);
            echo json_encode(["message" => "Lỗi dữ liệu đầu vào", "errors" => $errors]);
            return;
        }

        $account = $this->accountModel->getAccountByUsername($username);
        if ($account && password_verify($password, $account->password)) {
            // Đăng nhập thành công, thiết lập session
            SessionHelper::login($account->username, $account->role);
            
            http_response_code(200);
            echo json_encode([
                "message" => "Đăng nhập thành công",
                "user" => [
                    "username" => $account->username,
                    "fullname" => $account->fullname,
                    "role" => $account->role
                ]
            ]);
        } else {
            http_response_code(401);
            $msg = $account ? "Mật khẩu không chính xác!" : "Tài khoản không tồn tại!";
            echo json_encode(["message" => $msg]);
        }
    }
}
