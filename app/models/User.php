<?php
class User {
    public static function all() {
        $db = new Database();
        $conn = $db->getConnection();
        $result = $conn->query("SELECT id, name, email, role FROM users");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function delete($id) {
        $db = new Database();
        $conn = $db->getConnection();
        return $conn->query("DELETE FROM users WHERE id = $id");
    }
}