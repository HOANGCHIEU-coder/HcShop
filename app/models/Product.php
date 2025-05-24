<?php
class Product {
    public static function allWithSize() {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "SELECT p.id, p.name, p.price, s.size, s.quantity, p.image
                FROM products p
                LEFT JOIN stock_quantity s ON p.id = s.product_id
                ORDER BY p.id, s.size";
        $result = $conn->query($sql);
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
    public static function delete($id) {
        $db = new Database();
        $conn = $db->getConnection();

        // Xóa bảng phụ trước
        $conn->query("DELETE FROM stock_quantity WHERE product_id = $id");
        return $conn->query("DELETE FROM products WHERE id = $id");
    }

    public static function findByIdWithSize($id) {
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT p.id, p.name, p.price, s.size, s.quantity
                FROM products p
                LEFT JOIN stock_quantity s ON p.id = s.product_id
                WHERE p.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

   public static function updateProductInfo($id, $name, $price)
   {
       $db = new Database();
       $conn = $db->getConnection();

       $sql = "UPDATE products SET name = ?, price = ? WHERE id = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("sdi", $name, $price, $id);
       $stmt->execute();
       $stmt->close();
   }

   public static function updateStockInfo($id, $original_size, $new_size, $quantity)
   {
       $db = new Database();
       $conn = $db->getConnection();

       $sql = "UPDATE stock_quantity SET size = ?, quantity = ? WHERE product_id = ? AND size = ?";
       $stmt = $conn->prepare($sql);
       $stmt->bind_param("siis", $new_size, $quantity, $id, $original_size);
       $stmt->execute();
       $stmt->close();
   }
}
