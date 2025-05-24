<?php
require_once '../app/core/App.php';

//Bắt route thủ công cho clear
if (isset($_GET['url']) && $_GET['url'] === 'CheckoutController/clear') {
    require_once '../app/controllers/CheckoutController.php';
    (new CheckoutController())->clear();
    exit;
}

// Mặc định chạy app MVC
require_once '../app/controllers/HomeController.php';
$app = new App();