<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/HCShopTest/styles/login.css">
</head>
<body>
<div class="login-box">
    <h2>Đăng nhập tài khoản</h2>
    <?php if (!empty($register_success)): ?>
        <div class="success" style="color:green; margin-bottom:10px;">
            ✅ Bạn đã đăng ký thành công! Vui lòng đăng nhập.
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>
    <div class="links">
        <a href="/HCShopTest/public/RegisterController/index">Đăng ký</a>
        <a href="/HCShopTest/public/ForgotPasswordController/index">Quên mật khẩu?</a>
    </div>
</div>
</body>
</html>
