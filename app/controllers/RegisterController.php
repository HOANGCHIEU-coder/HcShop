<?php
require_once(__DIR__ . '/../core/Database.php');
require_once(__DIR__ . '/../config/session_config.php');

class RegisterController {
    public function index() {
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $db = new Database();
        $conn = $db->getConnection();
            $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $password);

            if ($stmt->execute()) {
                header("Location: /HCShopTest/public/LoginController/index?register_success=1");
                exit();
            } else {
                $error = "Lỗi đăng ký: " . $conn->error;
            }
        }

        require_once __DIR__ . '/../views/register.php';
    }
}
