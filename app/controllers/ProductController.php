<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../config/session_config.php';

class ProductController {
    public function detail() {
        $db = new Database();
        $conn = $db->getConnection();

        $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Lấy thông tin sản phẩm
        $stmt = $conn->prepare("SELECT id, name, price, discount, description, image, style, material FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            die("<h2 style='text-align:center;'>Sản phẩm không tồn tại!</h2>");
        }

        // Lấy số lượng theo size
        $stockBySize = [];
        $stmt = $conn->prepare("SELECT size, quantity FROM stock_quantity WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $stockBySize[$row['size']] = $row['quantity'];
        }

        // Truyền dữ liệu sang view
        require_once __DIR__ . '/../views/product_detail.php';
    }

    public function index() {
        echo "<h2 style='text-align:center; color:gray;'> Hãy chọn sản phẩm cụ thể để xem chi tiết!</h2>";
    }
}
