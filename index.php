<?php
// Bắt đầu session ở đầu file index.php
session_start();

if (!defined('BASE_URL')) {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $baseDir = dirname($scriptName);
    $baseDir = rtrim($baseDir, '/\\');
    define('BASE_URL', $baseDir);
}

// Nạp SessionHelper toàn cục
require_once 'app/helpers/SessionHelper.php';

require_once 'app/models/ProductModel.php';

// Product/add
$url = $_GET['url'] ?? '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Thêm định tuyến cho RESTful API
if (isset($url[0]) && strtolower($url[0]) === 'api') {
    $resource = isset($url[1]) ? strtolower($url[1]) : '';
    $id = isset($url[2]) && $url[2] !== '' ? $url[2] : null;

    if ($resource === 'product') {
        require_once 'app/controllers/ProductApiController.php';
        $controller = new ProductApiController();
        $controller->handleRequest($id);
        exit;
    } elseif ($resource === 'category') {
        require_once 'app/controllers/CategoryApiController.php';
        $controller = new CategoryApiController();
        $controller->handleRequest($id);
        exit;
    } elseif ($resource === 'account') {
        require_once 'app/controllers/AccountApiController.php';
        $controller = new AccountApiController();
        $action = isset($url[2]) ? $url[2] : '';
        $controller->handleRequest($action);
        exit;
    } else {
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(404);
        echo json_encode(["message" => "Endpoint API không tồn tại"]);
        exit;
    }
}

// Kiểm tra phần đầu tiên của URL để xác định controller
$controllerName = isset($url[0]) && $url[0] != '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';

// Kiểm tra phần thứ hai của URL để xác định action
$action = isset($url[1]) && $url[1] != '' ? $url[1] : 'index';

// die ("controller=$controllerName - action=$action");

// Kiểm tra xem controller và action có tồn tại không
if (!file_exists('app/controllers/' . $controllerName . '.php')) {
    // Xử lý không tìm thấy controller
    die('Controller not found');
}

require_once 'app/controllers/' . $controllerName . '.php';

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    // Xử lý không tìm thấy action
    die('Action not found');
}

// Gọi action với các tham số còn lại (nếu có)
call_user_func_array([$controller, $action], array_slice($url, 2));
