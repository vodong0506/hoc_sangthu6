<?php
class SessionHelper
{
    // Khởi động session nếu chưa tồn tại
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Đăng nhập người dùng (Lưu thông tin vào session)
    public static function login($username, $role)
    {
        self::start();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
    }

    // Đăng xuất người dùng (Xóa toàn bộ session)
    public static function logout()
    {
        self::start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy();
    }

    // Kiểm tra trạng thái đăng nhập
    public static function isLoggedIn()
    {
        self::start();
        return !empty($_SESSION['username']);
    }

    // Lấy tên người dùng hiện tại
    public static function getUsername()
    {
        self::start();
        return $_SESSION['username'] ?? null;
    }

    // Lấy vai trò của người dùng hiện tại
    public static function getRole()
    {
        self::start();
        return $_SESSION['role'] ?? null;
    }

    // Kiểm tra xem người dùng có phải admin không
    public static function isAdmin()
    {
        return self::getRole() === 'admin';
    }

    // Yêu cầu đăng nhập, chuyển hướng nếu chưa đăng nhập
    public static function requireLogin($redirectUrl = null)
    {
        if (!self::isLoggedIn()) {
            $url = $redirectUrl ?: (BASE_URL . '/account/login');
            header("Location: " . $url);
            exit;
        }
    }

    // Yêu cầu quyền admin, chuyển hướng nếu không đủ thẩm quyền
    public static function requireAdmin($redirectUrl = null)
    {
        self::requireLogin($redirectUrl);
        if (!self::isAdmin()) {
            $url = $redirectUrl ?: (BASE_URL . '/');
            $_SESSION['error'] = "Bạn không có quyền truy cập vào khu vực quản trị!";
            header("Location: " . $url);
            exit;
        }
    }
}
