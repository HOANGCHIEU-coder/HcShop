<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /HcShopTest/public/index.php?controller=login&action=index');
    exit;
}