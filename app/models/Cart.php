<?php
require_once __DIR__ . '/../core/Database.php';

class Cart extends Database {

    public static function removeItem($id) {
        if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        return $_SESSION['cart'] ?? [];
    }

    public static function updateItem($id, $action) {
        
        $messages = [];

        if (!isset($_SESSION['cart'][$id])) return [$_SESSION['cart'], $messages];

        $item = $_SESSION['cart'][$id];
        $product_id = $item['id'];
        $size = $item['size'];
        $quantity = $item['quantity'];

        // Kết nối CSDL từ class cha (Database)
        $db = new self();
        $conn = $db->conn;

        $sql = "SELECT quantity FROM stock_quantity WHERE product_id = ? AND size = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $product_id, $size);
        $stmt->execute();
        $result = $stmt->get_result();
        $stock = $result->fetch_assoc()['quantity'] ?? 0;


        if ($action === 'increase') {
            $current = $_SESSION['cart'][$id]['quantity'];


            if ($current < $stock) {
                $_SESSION['cart'][$id]['quantity'] += 1;
            } else {
                $messages[$id] = "❌ Sản phẩm đã đạt giới hạn!";
            }

        } elseif ($action === 'decrease' && $quantity > 1) {
               $_SESSION['cart'][$id]['quantity']-= 1;
        }

            return [$_SESSION['cart'], $messages];
        }
}
