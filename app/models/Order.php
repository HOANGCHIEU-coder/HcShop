<?php
class Order {
    public static function getOverviewStats() {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT
                    (SELECT COUNT(*) FROM orders WHERE DATE(created_at) = CURDATE()) AS totalOrders,
                    (SELECT COUNT(*) FROM products) AS totalProducts,
                    (SELECT COUNT(*) FROM users) AS totalUsers,
                    (SELECT SUM(order_items.price * order_items.quantity)
                        FROM order_items
                        JOIN orders ON order_items.order_id = orders.id) AS totalRevenue";

        $result = $conn->query($sql);
        return $result->fetch_assoc();
    }

    public static function allWithDetails() {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "SELECT orders.id AS order_id, users.name AS customer_name,
                       orders.created_at AS order_date,
                       order_items.product_name, order_items.price, order_items.quantity, order_items.size
                FROM orders
                JOIN order_items ON orders.id = order_items.order_id
                JOIN users ON orders.user_id = users.id";
        $result = $conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }
    public static function createOrder($conn, $user_id, $fullname, $phone, $address, $note, $items) {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Tạo đơn hàng
        $stmt = $conn->prepare("INSERT INTO orders (fullname, phone, address, note, total, user_id)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdi", $fullname, $phone, $address, $note, $total, $user_id);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Thêm từng sản phẩm
        $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, price, quantity, size)
                                     VALUES (?, ?, ?, ?, ?)");

        foreach ($items as $item) {
            $stmt_item->bind_param(
                "isdss",
                $order_id,
                $item['name'],
                $item['price'],
                $item['quantity'],
                $item['size']
            );
            $stmt_item->execute();
        }

        return $order_id;
    }

}
