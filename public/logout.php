<?php
session_start();

// Xoá riêng từng session liên quan đến đăng nhập
unset($_SESSION['user_id']);
unset($_SESSION['admin_id']);
unset($_SESSION['username']); 

// Chuyển hướng về trang chủ hoặc trang login
header("Location: /HCShopTest/public/index.php");
exit;
