<?php
class Contact {
    public static function all() {
        require __DIR__ . '/../core/Database.php';
        $db = new Database();
        $conn = $db->getConnection();

        $sql = "SELECT name, email, message, sent_at FROM contact_messages ORDER BY sent_at DESC";
        $result = $conn->query($sql);

        $contacts = [];
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }

        return $contacts;
    }
}
