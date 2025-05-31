
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
    <link rel="stylesheet" type="text/css" href="/HCShopTest/styles/cart.css">
</head>
<body>
<div class="cart-container">
    <h1>🛒 Giỏ hàng của bạn</h1>

    <?php if (empty($cart)): ?>
        <div id="cart-empty-wrapper">
            <p class="empty-message">🛒Giỏ hàng của bạn đang trống 😢</p>
            <a href="/HCShopTest/public/HomeController/index" class="back-button">💖Quay lại mua sắm</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <form method="post">
                    <button type="submit" name="view_orders" class="btn-view-order">📄 Xem hóa đơn đã mua</button>
                </form>
            <?php endif; ?>
        </div>

        <?php
        if (isset($_POST['view_orders']) && isset($_SESSION['user_id'])):
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
        ?>
        <div id="order-history">
            <h2>🧰 Lịch sử đơn hàng của bạn</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Họ tên</th>
                            <th>SĐT</th>
                            <th>Địa chỉ</th>
                            <th>Ghi chú</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td><?php echo $row['fullname']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['note']; ?></td>
                            <td><?php echo number_format($row['total'], 0, ',', '.'); ?>đ</td>
                            <td><?= htmlspecialchars($row['status_order']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align:center;">📍 Bạn chưa có đơn hàng nào.</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $cart_key => $item):
                    $subtotal = $item['price'] * $item['quantity'];

                ?>
                <tr>
                    <td><img src="/HCShopTest/public/images/<?php echo $item['image']; ?>" alt="" width="60"></td>
                    <td><?php echo $item['name']; ?> (Size <?php echo $item['size']; ?>)</td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                    <td>
                        <form method="post" class="quantity-form">
                            <input type="hidden" name="update_id" value="<?php echo $cart_key; ?>">
                            <button type="submit" name="action" value="decrease">➖</button>
                            <span><?php echo $item['quantity']; ?></span>
                            <button type="submit" name="action" value="increase">➕</button>
                        </form>
                        <?php if (!empty($messages[$cart_key])): ?>
                            <p class="message"><?php echo $messages[$cart_key]; ?></p>
                        <?php endif; ?>
                    </td>
                    <td><?php echo number_format($subtotal, 0, ',', '.'); ?>đ</td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="remove_id" value="<?php echo $cart_key; ?>">
                            <button type="submit" class="remove">🗑️</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <strong>Tổng cộng: <?php echo number_format($total, 0, ',', '.'); ?>đ</strong>
        </div>
        <div class="actions">
            <a href="/HCShopTest/public/HomeController/index" class="btn">⬅️ Tiếp tục mua hàng</a>
            <a href="/HCShopTest/public/CheckoutController/index" class="btn primary">💳 Thanh toán</a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
