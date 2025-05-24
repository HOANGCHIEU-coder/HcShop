<?php
require_once(__DIR__ . '/../core/Database.php');
require_once(__DIR__ . '/../config/session_config.php');

class ForgotPasswordController {
    public function index() {
        $db = new Database();
        $conn = $db->getConnection();

        $showEmailForm = true;
        $showPasswordForm = false;
        $passwordChanged = false;
        $errorMessage = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Gửi email
            if (isset($_POST['submit_email'])) {
                $email = $_POST['email'];
                $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $token = bin2hex(random_bytes(50));
                    $_SESSION['email'] = $email;

                    $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
                    $stmt->bind_param("ss", $token, $email);
                    $stmt->execute();

                    $showEmailForm = false;
                    $showPasswordForm = true;
                } else {
                    $errorMessage = "Email không tồn tại trong hệ thống.";
                }
            }

            // Đổi mật khẩu
            if (isset($_POST['submit_new_password'])) {
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                $email = $_SESSION['email'] ?? null;

                if ($new_password === $confirm_password && $email) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE email = ?");
                    $stmt->bind_param("ss", $hashed_password, $email);
                    $stmt->execute();
                    $passwordChanged = true;
                    unset($_SESSION['email']);
                } else {
                    $errorMessage = "Mật khẩu xác nhận không khớp!";
                }
            }
        }

        require_once __DIR__ . '/../views/forgot_password.php';
    }
}
