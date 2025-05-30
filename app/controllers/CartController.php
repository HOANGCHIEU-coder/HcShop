<?php
session_start();
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../models/Cart.php';


class CartController
{
    public function index()
    {

        if (!isset($_SESSION['user_id'])) {
            header('Location: /HCShopTest/public/LoginController/index');
            exit;
        }

        $db = new Database();
        $conn = $db->getConnection();

        $cart = $_SESSION['cart'] ?? [];
        $messages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xóa sản phẩm khỏi giỏ
            if (isset($_POST['remove_id'])) {
                $cart = Cart::removeItem($_POST['remove_id']);
            }
            // Tăng/giảm số lượng
            if (isset($_POST['update_id'], $_POST['action'])) {
                list($cart, $messages) = Cart::updateItem($_POST['update_id'], $_POST['action']);

            }

            // Xem đơn hàng đã đặt
            if (isset($_POST['view_orders'])) {
            $db = new Database();
            $conn = $db->getConnection();

            $user_id = (int) $_SESSION['user_id'];
            $sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC";
            $result = $conn->query($sql);

            $orders = [];
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $orders[] = $row;
                }
            }
        }

        }


        // Tính tổng tiền
        $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        // Gọi view tương ứng
        require_once __DIR__ . '/../views/cart/index.php';
    }

        public function add()
    {
        header('Content-Type: application/json');

        $db = new Database();
        $conn = $db->getConnection();

        $productId = $_POST['product_id'] ?? null;
        $size = $_POST['size'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$productId || !$size) {
            echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu']);
            return;
        }

        $stmt = $conn->prepare("SELECT name, image, price FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            echo json_encode(['status' => 'error', 'message' => 'Sản phẩm không tồn tại']);
            return;
        }

        // Kiểm tra mode buy_now
        $mode = $_GET['mode'] ?? '';
        if ($mode === 'buy_now') {
            $_SESSION['buy_now'] = [
                'id' => $productId,
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'size' => $size,
                'quantity' => $quantity
            ];
            echo json_encode(['status' => 'success', 'message' => 'Đã thêm vào giỏ (buy now)']);
            return;
        }

        // Thêm vào giỏ hàng thông thường
        $key = $productId . '_' . $size;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$key])) {
        var_dump($_SESSION['cart'][$key]['quantity']);die;

        } else {
            $_SESSION['cart'][$key] = [
                'id' => $productId,
                'name' => $product['name'],
                'image' => $product['image'],
                'price' => $product['price'],
                'size' => $size,
                'quantity' => $quantity
            ];
        }

        echo json_encode(['status' => 'success', 'message' => 'Đã thêm vào giỏ']);
        }

        public function buyNow() {
            $product_id = $_POST['product_id'];
            $size = $_POST['size'];
            $quantity = $_POST['quantity'];

            // Lấy thông tin sản phẩm từ DB (giả sử có hàm getProductById)
            $db = new Database();
            $conn = $db->getConnection();
            $stmt = $conn->prepare("SELECT id, name, image, price FROM products WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $_SESSION['buy_now'] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'size' => $size,
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
                echo 'OK';
            } else {
                http_response_code(400);
                echo 'Product not found';
            }
            exit;
        }
}
