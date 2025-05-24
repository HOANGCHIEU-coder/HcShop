<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../config/session_config.php';

class ContactController {
    public function index() {
        $db = new Database();
        $conn = $db->getConnection();
        $success_message = '';
        $error_message = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars(trim($_POST['name']));
            $email = htmlspecialchars(trim($_POST['email']));
            $message = htmlspecialchars(trim($_POST['message']));

            if (empty($name) || empty($email) || empty($message)) {
                $error_message = "Tất cả các trường đều là bắt buộc!";
            } else {
                $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $message);

                if ($stmt->execute()) {
                    $success_message = "Tin nhắn đã được gửi thành công!";
                } else {
                    $error_message = "Không thể gửi tin nhắn, vui lòng thử lại!";
                }

                $stmt->close();
            }
        }

        // Load view
        require_once __DIR__ . '/../views/contact.php';
    }
}
