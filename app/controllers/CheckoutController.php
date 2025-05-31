<?php
session_start();
require_once(__DIR__ . '/../core/Database.php');
require_once(__DIR__ . '/../models/Order.php');

class CheckoutController {
    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['redirect_after_login'] = '/HCShopTest/public/CheckoutController/index';
            header('Location: /HCShopTest/public/LoginController/index');
            exit;
        }

        $db = new Database();
        $conn = $db->getConnection();

        $mode = $_GET['mode'] ?? '';
        $items = [];

        // Lấy sản phẩm từ session
        if ($mode === 'buy_now' && isset($_SESSION['buy_now'])) {
            $items = [$_SESSION['buy_now']];
        } elseif (isset($_SESSION['cart'])) {
            $items = $_SESSION['cart'];
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Xử lý đặt hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($items)) {
            $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
            $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
            $address  = mysqli_real_escape_string($conn, $_POST['address']);
            $note     = mysqli_real_escape_string($conn, $_POST['note'] ?? '');
            $user_id  = (int)$_SESSION['user_id'];

            // Gọi Model để xử lý lưu đơn hàng
            $status_order = 'Chờ xử lý'; 
            $order_id = Order::createOrder($conn, $user_id, $fullname, $phone, $address, $note, $items, $status_order);

            // Lưu thông tin để hiển thị ở trang cảm ơn
            $_SESSION['order_info'] = [
                'fullname' => $fullname,
                'phone'    => $phone,
                'address'  => $address,
                'note'     => $note
            ];

            // Xóa session giỏ hàng
            if ($mode === 'buy_now') {
                unset($_SESSION['buy_now']);
            } else {
                unset($_SESSION['cart']);
            }

            // Chuyển hướng tránh submit lại
            header("Location: /HCShopTest/public/CheckoutController/index?success=1");
            exit;
        }

        // Hiển thị trang cảm ơn
        $show_success = isset($_GET['success']) && $_GET['success'] == 1;
        $fullname = $phone = $address = $note = '';

        if ($show_success && isset($_SESSION['order_info'])) {
            $fullname = $_SESSION['order_info']['fullname'] ?? '';
            $phone    = $_SESSION['order_info']['phone'] ?? '';
            $address  = $_SESSION['order_info']['address'] ?? '';
            $note     = $_SESSION['order_info']['note'] ?? '';
        }

        require __DIR__ . '/../views/checkout.php';
    }
    public function clear() {
            unset($_SESSION['order_info']);
            unset($_SESSION['last_order_id']);
            header('Location: /HCShopTest/public/HomeController/index');
            exit;
        }
}
