<?php
session_start();

if (!defined('BASE_URL')) {
    define('BASE_URL', '/lab_02');
}

$url = $_GET['url'] ?? '';
$url = trim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = $url === '' ? [] : explode('/', $url);

// Mặc định controller và action
$controllerName = isset($url[0]) && $url[0] !== '' ? ucfirst($url[0]) . 'Controller' : 'DefaultController';
$action = isset($url[1]) && $url[1] !== '' ? $url[1] : 'index';

$controllerFile = __DIR__ . '/app/controllers/' . $controllerName . '.php';
if (!file_exists($controllerFile)) {
    http_response_code(404);
    exit('Controller not found');
}

require_once $controllerFile;

if (!class_exists($controllerName)) {
    http_response_code(404);
    exit('Controller class not found');
}

$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    exit('Action not found');
}

$pathParams = array_slice($url, 2);
$singleParamActions = ['edit', 'delete', 'show', 'getApi'];
if (empty($pathParams) && isset($_GET['id']) && in_array($action, $singleParamActions, true)) {
    $pathParams[] = $_GET['id'];
}

call_user_func_array([$controller, $action], $pathParams);
