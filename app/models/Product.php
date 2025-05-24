<?php
class Product
{
    public static function allWithSize()
    {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "SELECT p.id, p.name, p.price, p.image, s.size, s.quantity
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

    // Thêm sản phẩm mới (nhận ảnh là URL, không upload file)
    public static function insertWithSize($name, $price, $image, $size, $quantity)
    {
        $db = new Database();
        $conn = $db->getConnection();

        // Kiểm tra sản phẩm đã tồn tại chưa (theo tên)
        $sqlCheck = "SELECT id FROM products WHERE name = ? LIMIT 1";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $name);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            // Đã có sản phẩm này
            $stmtCheck->bind_result($product_id);
            $stmtCheck->fetch();
            $stmtCheck->close();
            // Có thể update lại thông tin image/price nếu muốn (tùy bố)
        } else {
            // Thêm mới sản phẩm
            $stmtCheck->close();
            $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sds", $name, $price, $image);
            $stmt->execute();
            $product_id = $stmt->insert_id;
            $stmt->close();
        }

        // Kiểm tra tồn kho đã có size này chưa
        $sqlSQ = "SELECT id FROM stock_quantity WHERE product_id = ? AND size = ? LIMIT 1";
        $stmtSQ = $conn->prepare($sqlSQ);
        $stmtSQ->bind_param("is", $product_id, $size);
        $stmtSQ->execute();
        $stmtSQ->store_result();
        if ($stmtSQ->num_rows > 0) {
            // Đã có size này, cập nhật số lượng
            $stmtSQ->close();
            $stmtUpdate = $conn->prepare("UPDATE stock_quantity SET quantity = ? WHERE product_id = ? AND size = ?");
            $stmtUpdate->bind_param("iis", $quantity, $product_id, $size);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            // Thêm mới tồn kho
            $stmtSQ->close();
            $stmtInsert = $conn->prepare("INSERT INTO stock_quantity (product_id, size, quantity) VALUES (?, ?, ?)");
            $stmtInsert->bind_param("isi", $product_id, $size, $quantity);
            $stmtInsert->execute();
            $stmtInsert->close();
        }
        return $product_id;
    }


    public static function delete($id)
    {
        $db = new Database();
        $conn = $db->getConnection();
        $conn->query("DELETE FROM stock_quantity WHERE product_id = $id");
        return $conn->query("DELETE FROM products WHERE id = $id");
    }

    public static function findByIdWithSize($id)
    {
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "SELECT p.id, p.name, p.price, p.image, s.size, s.quantity
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
