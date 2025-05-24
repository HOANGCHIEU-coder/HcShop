
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/HCShopTest/styles/admin.css">
    <link rel="stylesheet" href="/HCShopTest/styles/ad.css">
    <link rel="stylesheet"href="/HCShopTest/styles/ad2.css">
    <link rel="stylesheet" href="/HCShopTest/styles/sua.css">
    <link rel="stylesheet" href="/HCShopTest/styles/dasbroa.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <div class="nav flex-column">
            <div class="nav-item">
                <a href="admin_dashboard.php" class="nav-link"><i class="fa fa-home"></i> Tổng quan</a>
            </div>
            <div class="nav-item">
                <a href="/HCShopTest/public/AdminController/dashboard?action=manage_products" class="nav-link">
                    <i class="fa fa-cogs"></i> Quản lý sản phẩm
                </a>
            </div>
            <div class="nav-item">
                    <a href="/HCShopTest/public/AdminController/dashboard?action=manage_orders"  class="nav-link" > <i class="fa fa-box"></i> Quản lý đơn hàng</a>
            </div>
            <div class="nav-item">
                <a href="/HCShopTest/public/AdminController/dashboard?action=manage-users" class="nav-link">
                    <i class="fa fa-users"></i> Quản lý người dùng
                </a>
            </div>
            <div class="nav-item">
                <a href="/HCShopTest/public/AdminController/dashboard?action=manage-contact" class="nav-link">
                  <i class="fa fa-phone"></i> Liên hệ
                </a>
            </div>
            <div class="nav-item">
                <a href="/HCShopTest/public/login/logout" class="nav-link"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a>
            </div>
        </div>
    </div>


        <!-- Main Content (Admin section) -->
        <div class="admin-section">
            <div class="admin-header">
                <h1>Chào mừng, Admin <?php echo $_SESSION['user_name']; ?></h1>
            </div>
            <?php if (!empty($msg)): ?>
                <div style="color: green; font-weight: bold; margin-bottom: 10px;"><?php echo $msg; ?></div>
            <?php endif; ?>
            <?php if (empty($action)): ?>
                <div class="dashboard-widgets">
                    <div class="widget">
                        <h4>🛒 Đơn hàng hôm nay</h4>
                        <p><?= $overview['totalOrders'] ?></p>
                    </div>
                    <div class="widget">
                        <h4>👕 Tổng sản phẩm</h4>
                        <p><?= $overview['totalProducts'] ?></p>
                    </div>
                    <div class="widget">
                        <h4>👤 Người dùng</h4>
                        <p><?= $overview['totalUsers'] ?></p>
                    </div>
                    <div class="widget">
                        <h4>💵 Doanh thu tổng quan</h4>
                        <p><?= number_format($overview['totalRevenue'], 0, ',', '.') ?>₫</p>
                    </div>
                </div>

                <!-- Biểu đồ cột hiển thị tổng quan -->
                <div class="chart-container" style="width: 80%; margin: 0 auto; padding-top: 50px;">
                    <canvas id="myChart"></canvas>
                </div>
            <?php endif; ?>

            <!--Danh saachs sản phẩm -->
            <?php if ($action === 'manage_products'): ?>
                <h2 style="margin-left: 30px;">📦 Danh sách sản phẩm</h2>
                <table border="1" cellpadding="10" cellspacing="0"
                       style="width: 95%; margin: 20px; color: #000; background-color: #fff;">
                    <thead>
                        <tr style="background-color: #eee;">
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($products as $p): ?>
                        <?php
                            $isEditing = isset($_GET['edit_id'], $_GET['edit_size']) &&
                                         $_GET['edit_id'] == $p['id'] &&
                                         $_GET['edit_size'] == $p['size'];
                        ?>
                        <?php if ($isEditing): ?>
                            <!-- Dòng đang sửa -->
                            <tr id="edit-<?= $p['id'] ?>-<?= $p['size'] ?>">
                                <form method="POST"
                                      action="/HCShopTest/public/AdminController/edit_product"
                                      enctype="multipart/form-data"
                                      class="edit-form"
                                      data-id="<?= $p['id'] ?>"
                                      data-size="<?= $p['size'] ?>">

                                    <td>
                                        <?= $p['id'] ?>
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <input type="hidden" name="original_size" value="<?= $p['size'] ?>">
                                    </td>
                                    <td><input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>"></td>
                                    <td><input type="number" name="price" value="<?= $p['price'] ?>"></td>
                                    <td><input type="text" name="size" value="<?= $p['size'] ?>"></td>
                                    <td><input type="number" name="quantity" value="<?= $p['quantity'] ?>"></td>
                                    <td><img src="/HCShopTest/public/images/<?= $p['image'] ?>" width="60"></td>
                                    <td style="display: flex; flex-direction: column; gap: 6px;">
                                        <button type="submit" class="button-action" style="background-color: #4CAF50; color: white; border: none; padding: 6px; border-radius: 4px;">📂 Lưu</button>
                                        <button type="button" class="button-action" style="background-color: #f44336; color: white; border: none; padding: 6px; border-radius: 4px;"
                                                onclick="cancelEdit('<?= $p['id'] ?>','<?= $p['size'] ?>')">❌ Huỷ</button>
                                    </td>
                                </form>
                            </tr>
                        <?php else: ?>
                            <!-- Dòng bình thường -->
                            <tr id="row-<?= $p['id'] ?>-<?= $p['size'] ?>">
                                <td><?= $p['id'] ?></td>
                                <td><?= htmlspecialchars($p['name']) ?></td>
                                <td><?= number_format($p['price']) ?>₫</td>
                                <td><?= $p['size'] ?></td>
                                <td><?= $p['quantity'] ?></td>
                                <td><img src="/HCShopTest/public/images/<?= $p['image'] ?>" width="60"></td>
                                <td style="display: flex; flex-direction: column; gap: 6px;">
                                    <a href="/HCShopTest/public/AdminController/dashboard?action=manage_products&edit_id=<?= $p['id'] ?>&edit_size=<?= $p['size'] ?>"
                                       onclick="editRow(event, '<?= $p['id'] ?>', '<?= $p['size'] ?>')">
                                        <button class="button-action" style="background-color: #2196F3; color: white; border: none; padding: 6px; border-radius: 4px;">✏️ Sửa</button>
                                    </a>
                                    <a href="/HCShopTest/public/AdminController/delete_product?id=<?= $p['id'] ?>&size=<?= $p['size'] ?>"
                                       onclick="return confirm('Xoá sản phẩm này?')">
                                        <button class="button-action" style="background-color: #f44336; color: white; border: none; padding: 6px; border-radius: 4px;">🗑️ Xoá</button>
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>


            <!-- Quản lý đơn hàng -->
            <?php elseif ($action == 'manage_orders'): ?>
            <h2>Danh sách đơn hàng</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Tên Người Dùng</th>
                            <th>Thời gian đặt hàng</th>
                            <th>Tên sản phẩm </th>
                            <th>Giá sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $row): ?>
                                <tr>
                                    <td><?= $row['order_id'] ?></td>
                                    <td><?= $row['customer_name'] ?></td>
                                    <td><?= $row['order_date'] ?></td>
                                    <td><?= $row['product_name'] ?></td>
                                    <td><?= number_format($row['price'], 0, ',', '.') ?>₫</td>
                                    <td><?= $row['quantity'] ?></td>
                                    <td><?= $row['size'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7">Không có đơn hàng nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <!-- QLy người dùng-->
            <?php elseif ($action === 'manage-users'): ?>
                <h2>👤 Quản lý người dùng</h2>
                <table border="1" cellpadding="10" cellspacing="0" style="width: 95%; margin: 20px; color: #000; background-color: #fff;">
                    <thead>
                        <tr style="background-color: #eee;">
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $row): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['role'] ?></td>
                                    <td>
                                        <a href="/HCShopTest/public/AdminController/delete_user?id=<?= $row['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                            <button style="color: red;">Xóa</button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5">Không có người dùng nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            <!--Phần Contact -->
           <?php if ($action === 'manage-contact'): ?>
               <h2>📩 Thông báo từ khách hàng</h2>
               <table border="1" cellpadding="10" cellspacing="0" style="width: 95%; margin: 20px auto;">
                   <thead style="background: #eee;">
                       <tr>
                           <th>Tên</th>
                           <th>Email</th>
                           <th>Nội dung</th>
                           <th>Ngày gửi</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php if (!empty($contacts)): ?>
                           <?php foreach ($contacts as $contact): ?>
                               <tr>
                                   <td><?= htmlspecialchars($contact['name']) ?></td>
                                   <td><?= htmlspecialchars($contact['email']) ?></td>
                                   <td><?= nl2br(htmlspecialchars($contact['message'])) ?></td>
                                   <td><?= $contact['sent_at'] ?></td>
                               </tr>
                           <?php endforeach; ?>
                       <?php else: ?>
                           <tr><td colspan="4">Không có tin nhắn nào.</td></tr>
                       <?php endif; ?>
                   </tbody>
               </table>
           <?php endif; ?>

           <?php endif; ?>
    </div>
<?php if (empty($action)): ?>

        <!--  thư viện Chart.js-->
        <canvas id="myChart"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const totalOrders = <?php echo json_encode($overview['totalOrders'] ?? 0); ?>;
            const totalProducts = <?php echo json_encode($overview['totalProducts'] ?? 0); ?>;
            const totalUsers = <?php echo json_encode($overview['totalUsers'] ?? 0); ?>;
            const totalRevenue = <?php echo json_encode($overview['totalRevenue'] ?? 0); ?>;

            // Biểu đồ cột
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Đơn hàng', 'Tổng sản phẩm', 'Người dùng', 'Doanh thu'],
                    datasets: [{
                        label: 'Số liệu tổng quan',
                        data: [totalOrders, totalProducts, totalUsers, totalRevenue],
                        backgroundColor: ['#FF5733', '#FFC300', '#28B463', '#3498DB'],
                        borderColor: ['#FF5733', '#FFC300', '#28B463', '#3498DB'],
                        borderWidth: 1,
                        hoverBackgroundColor: ['#FF6F61', '#FFB533', '#33B57F', '#5DADE2']
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 30
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        </script>
<?php endif; ?>
    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Hệ thống quản lý sản phẩm. Tất cả quyền lợi được bảo lưu bởi Hc Shop.</p>
    </footer>
    <script src="/HCShopTest/js/delete.js"></script>
    <script src="/HCShopTest/js/admin.js"></script>
    <script src="/HCShopTest/js/sua.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function editRow(event, id, size) {
        event.preventDefault(); // 🚫 Ngăn trình duyệt chuyển trang theo <a href>
        // Dùng pushState để cập nhật URL mà không reload
        const url = new URL(window.location);
        url.searchParams.set('edit_id', id);
        url.searchParams.set('edit_size', size);
        history.pushState({}, '', url);

        // Reload nhẹ để form hiện mà vẫn giữ URL đúng
        location.reload(); // Hoặc nếu bạn dùng AJAX thì thay bằng showForm(id, size)
    }

    // Khi bấm nút ❌ Huỷ
    function cancelEdit() {
        const url = new URL(window.location);
        url.searchParams.delete('edit_id');
        url.searchParams.delete('edit_size');
        history.pushState({}, '', url);
        location.reload(); // hoặc ẩn form nếu là modal
    }
    </script>
   <script>
     function saveEdit(id, originalSize) {
         const row = document.getElementById(`row-${id}-${originalSize}`);
         const name = row.querySelector('input[name="name"]').value;
         const price = row.querySelector('input[name="price"]').value;
         const size = row.querySelector('input[name="size"]').value;
         const quantity = row.querySelector('input[name="quantity"]').value;

         const formData = new FormData();
         formData.append('id', id);
         formData.append('original_size', originalSize);
         formData.append('name', name);
         formData.append('price', price);
         formData.append('size', size);
         formData.append('quantity', quantity);

         fetch('/HCShopTest/public/AdminController/edit_product', {
             method: 'POST',
             headers: {
                 'X-Requested-With': 'XMLHttpRequest' // Cần có để server biết là Ajax
             },
             body: formData
         })
         .then(response => response.text())
         .then(data => {
             if (data.trim() === 'success') {
                 alert('✔ Lưu thành công!');
                 location.reload();
             } else {
                 alert('❌ Lỗi khi lưu (server không trả về "success").');
             }
         });
     }
   </script>



</body>
</html>
