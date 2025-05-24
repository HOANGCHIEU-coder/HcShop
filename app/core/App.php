<?php

class App {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();

        // 1. Lấy tên controller
        if (isset($url[0]) && file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Lấy tên method (action)
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // 3. Lấy các tham số còn lại
        $this->params = $url ? array_values($url) : [];

        // 4. Gọi controller & action
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $base = '/HCShopTest/public/';
        if (strpos($path, $base) === 0) {
            $path = substr($path, strlen($base));
        }

        return $path ? explode('/', rtrim($path, '/')) : [];
    }
}
