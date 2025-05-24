
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="/HCShopTest/styles/checkout.css">
</head>
<body>
<div class="checkout-container">
    <?php if ($show_success): ?>
        <div class="success">
            <h2>🎉 Cảm ơn bạn, <?php echo htmlspecialchars($fullname); ?>!</h2>
            <p>Đơn hàng của bạn đã được ghi nhận. Vui lòng chú ý điện thoại khi đơn hàng giao</p>
            <p>📞 SĐT: <strong><?php echo htmlspecialchars($phone); ?></strong></p>
            <p>🏠 Giao tới: <strong><?php echo htmlspecialchars($address); ?></strong></p>
            <?php if (!empty($note)): ?>
                <p>📝 Ghi chú: <em><?php echo htmlspecialchars($note); ?></em></p>
            <?php endif; ?>
            <form method="post" action="/HCShopTest/public/CheckoutController/clear">
                <button type="submit" class="btn">⬅️ Quay lại trang chủ</button>
            </form>
        </div>
    <?php elseif (empty($items)): ?>
        <div class="empty-cart">
            <h2>🛒 <?php echo (isset($mode) && $mode === 'buy_now') ? 'Bạn chưa chọn sản phẩm để mua ngay.' : 'Giỏ hàng trống. Quay lại <a href="/HCShopTest/public/HomeController/index">mua sắm</a> nhé!'; ?></h2>
        </div>
    <?php else: ?>
        <!-- Chỉ hiển thị form khi chưa đặt hàng thành công -->
        <h1>💳 Thanh toán đơn hàng</h1>
        <h2>🛍️ Sản phẩm</h2>
        <table>
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Size</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['size']); ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <h3 style="text-align:right; margin-top: 10px;">Tổng cộng: <strong><?php echo number_format($total, 0, ',', '.'); ?>đ</strong></h3>

        <form method="post" style="margin-top: 30px;">
            <h2>🧍 Thông tin khách hàng</h2>
            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" name="fullname" id="fullname" required value="<?php echo htmlspecialchars($fullname); ?>">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" name="phone" id="phone" required value="<?php echo htmlspecialchars($phone); ?>">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ giao hàng:</label>
                <textarea name="address" id="address" required><?php echo htmlspecialchars($address); ?></textarea>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú (tuỳ chọn):</label>
                <textarea name="note" id="note"><?php echo htmlspecialchars($note); ?></textarea>
            </div>
            <button type="submit" class="submit-btn">✅ Xác nhận đặt hàng</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
<?php
// Chỉ unset sau khi đã render xong HTML
if ($show_success && isset($_SESSION['order_info'])) {
    unset($_SESSION['order_info']);
}
?>
