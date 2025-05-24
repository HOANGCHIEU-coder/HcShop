<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Contact.php';
require_once __DIR__ . '/../middleware/admin_auth.php';

class AdminController {
    public function index() {
        header('Location: /HCShopTest/public/AdminController/dashboard');
        exit;
    }

    public function dashboard() {
        $action = $_GET['action'] ?? '';

        $overview = Order::getOverviewStats();
        $products = ($action === 'manage_products') ? Product::allWithSize() : [];
        $orders   = ($action === 'manage_orders') ? Order::allWithDetails() : [];
        $users    = ($action === 'manage-users') ? User::all() : [];
        $contacts = ($action === 'manage-contact') ? Contact::all() : [];

        require __DIR__ . '/../views/admin/admin_dashboard.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /HCShopTest/public/LoginController/index");
        exit;
    }

    public function delete_user() {
        if (!isset($_GET['id'])) {
            header('Location: /HCShopTest/public/AdminController/dashboard?action=manage-users');
            exit;
        }

        $userId = intval($_GET['id']);
        User::delete($userId);

        header('Location: /HCShopTest/public/AdminController/dashboard?action=manage-users');
        exit;
    }

    public function delete_contact() {
        if (!isset($_GET['id'])) {
            header('Location: /HCShopTest/public/AdminController/dashboard?action=manage-contact');
            exit;
        }

        Contact::delete($_GET['id']);
        header('Location: /HCShopTest/public/AdminController/dashboard?action=manage-contact');
        exit;
    }

    public function delete_product() {
        if (!isset($_GET['id'])) return;
        Product::delete($_GET['id']);
        header("Location: /HCShopTest/public/AdminController/dashboard?action=manage_products");
        exit;
    }

   public function edit_product()
   {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           $id = $_POST['id'];
           $original_size = $_POST['original_size'];
           $name = $_POST['name'];
           $price = $_POST['price'];
           $new_size = $_POST['size'];
           $quantity = $_POST['quantity'];

           Product::updateProductInfo($id, $name, $price);
           Product::updateStockInfo($id, $original_size, $new_size, $quantity);

           // Kiểm tra nếu là Ajax request
           if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
               echo "success"; // Đây là chỗ cần thiết
               exit;
           }

           // Nếu không phải Ajax thì redirect
           header("Location: /HCShopTest/public/AdminController/dashboard?action=manage_products");
           exit;
       }
   }
}
