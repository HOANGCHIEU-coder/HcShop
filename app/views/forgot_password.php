<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="/HCShopTest/styles/forgot.css">
</head>
<body>
<div class="container">

    <?php if ($showEmailForm): ?>
        <h2>Đổi mật khẩu</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Nhập email của bạn" required>
            <button type="submit" name="submit_email">Gửi yêu cầu đổi mật khẩu</button>
        </form>
    <?php endif; ?>

    <?php if ($showPasswordForm && !$passwordChanged): ?>
        <h2>Nhập mật khẩu mới</h2>
        <form method="POST">
            <input type="password" name="new_password" placeholder="Mật khẩu mới" required>
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
            <button type="submit" name="submit_new_password">Thay đổi mật khẩu</button>
        </form>
    <?php endif; ?>

    <?php if ($passwordChanged): ?>
        <div class="success-message">
            <p>Mật khẩu đã được thay đổi thành công!</p>
            <a href="/HCShopTest/public/LoginController/index">Quay lại đăng nhập</a>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

</div>
</body>
</html>
