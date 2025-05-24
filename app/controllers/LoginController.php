<?php
require_once(__DIR__ . '/../core/Database.php');
require_once(__DIR__ . '/../config/session_config.php');


class LoginController {
    public function index() {
        $error = '';
        $register_success = isset($_GET['register_success']) && $_GET['register_success'] == 1;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $db = new Database();
            $conn = $db->getConnection();


            $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($id, $name, $hashed_password, $role);

            if ($stmt->fetch() && password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['role'] = $role;

                if ($role === 'admin'){
                    $_SESSION['admin_id'] = $id;
                }

                // Chuyển hướng sau khi đăng nhập
                $redirect = ($role === 'admin')
                    ? '/HCShopTest/public/AdminController/dashboard'
                    : '/HCShopTest/public/HomeController/index';

                header("Location: $redirect");
                exit;
            } else {
                $error = "Sai email hoặc mật khẩu!";
            }
        }

        // Dữ liệu lỗi được truyền sang view để hiển thị
        require_once __DIR__ . '/../views/login.php';
    }
}
