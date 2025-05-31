<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/HCShopTest/styles/admin.css">
    <link rel="stylesheet" href="/HCShopTest/styles/ad.css">
    <link rel="stylesheet" href="/HCShopTest/styles/ad2.css">
    <link rel="stylesheet" href="/HCShopTest/styles/sua.css">
    <link rel="stylesheet" href="/HCShopTest/styles/dasbroa.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 2% auto;
            padding: 25px;
            border: none;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: border-color 0.3s ease;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close:hover {
            color: #333;
        }
    </style>
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
                <a href="/HCShopTest/public/AdminController/dashboard?action=manage_orders" class="nav-link"> <i class="fa fa-box"></i> Quản lý đơn hàng</a>
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
                <a href="/HCShopTest/public/logout.php" class="nav-link"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a>
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
            <button id="addProductBtn" style="margin: 20px; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">➕ Thêm sản phẩm</button>

            <!-- Popup Form -->
            <div id="addProductModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2 style="margin-bottom: 20px;">Thêm Sản Phẩm Mới</h2>
                    <form id="addProductForm" action="/HCShopTest/public/AdminController/add_product" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Tên sản phẩm: <input type="text" name="name" required></label>
                        </div>
                        <div class="form-group">
                            <label>Giá: <input type="number" name="price" required></label>
                        </div>
                        <div class="form-group">
                            <label>Mô tả: <textarea name="description"></textarea></label>
                        </div>
                        <div class="form-group">
                            <label>Danh mục: <input type="text" name="category"></label>
                        </div>
                        <div class="form-group">
                            <label>Label: <input type="text" name="label"></label>
                        </div>
                        <div class="form-group">
                            <label>Discount: <input type="number" name="discount" value="0"></label>
                        </div>
                        <div class="form-group">
                            <label>Style: <input type="text" name="style"></label>
                        </div>
                        <div class="form-group">
                            <label>Material: <input type="text" name="material"></label>
                        </div>
                        <div class="form-group">
                            <label>Ảnh sản phẩm (URL): <input type="file" name="url" required></label>
                        </div>
                        <div class="form-group">
                            <label>Size: <input type="text" name="size" required></label>
                        </div>
                        <div class="form-group">
                            <label>Số lượng: <input type="number" name="quantity" required></label>
                        </div>
                        <button type="submit" class="submit-btn">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>


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
                                    <td>
                                        <img src="/HCShopTest/public/images/<?= $p['image'] ?>" width="60">
                                        <div>
                                            Chọn ảnh thay thế<input type="file" name="url" id="">
                                        </div>
                                    </td>
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
                        <th>Trạng thái</th>
                        <th>Hành động</th>
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
                                <td><?= $row['status_order'] ?></td>
                                <td>
                                    <button class="updateStatusBtn" data-order="<?= $row['order_id'] ?>">Cập nhật trạng thái</button>
                                    <div id="statusModal" class="modal">
                                        <div class="modal-content">
                                            <form action="/HCShopTest/public/AdminController/update_order" method="post">
                                                <span class="close">&times;</span>
                                                <h2>Cập nhật trạng thái đơn hàng <?= $row['order_id'] ?></h2>
                                                <input type="hidden" id="orderId" name="order_id" value="<?= $row['order_id'] ?>">
                                                <select id="orderStatus" name="status">
                                                    <option value="Đã xác nhận">Đã xác nhận</option>
                                                    <option value="Đang chuẩn bị">Đang chuẩn bị</option>
                                                    <option value="Đang vận chuyển">Đang vận chuyển</option>
                                                    <option value="Giao hàng thành công">Giao hàng thành công</option>
                                                    <option value="Đã hủy">Đã hủy</option>
                                                    <option value="Đã thanh toán">Đã thanh toán</option>
                                                    <option value="Chờ xác nhận hủy">Chờ xác nhận hủy</option>
                                                    <option value="Đã nhận hàng">Đã nhận hàng</option>
                                                    <option value="Chưa nhận hàng">Chưa nhận hàng</option>
                                                </select>
                                                <input id="confirmStatus" type="submit" name="update_status" value="Xác nhận">
                                            </form>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>


                    <?php else: ?>
                        <tr>
                            <td colspan="7">Không có đơn hàng nào.</td>
                        </tr>
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
                        <tr>
                            <td colspan="5">Không có người dùng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
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
                        <tr>
                            <td colspan="4">Không có tin nhắn nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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

        // Xử lý hiển thị form thêm sản phẩm
        document.getElementById('addProductBtn').onclick = function() {
            document.getElementById('addProductModal').style.display = 'block';
        }

        // Đóng form khi nhấn nút đóng (x)
        document.querySelector('.close').onclick = function() {
            document.getElementById('addProductModal').style.display = 'none';
        }

        // Đóng form khi nhấn ra ngoài vùng form
        window.onclick = function(event) {
            const modal = document.getElementById('addProductModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.querySelector('#addProductForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.submit-btn');
            submitBtn.style.opacity = '0.7';
            submitBtn.textContent = 'Đang xử lý...';
        });

        // Fix input number styling
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('mousewheel', function(e) {
                e.preventDefault();
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".updateStatusBtn").forEach(button => {
                button.addEventListener("click", function() {
                    document.getElementById("orderId").value = this.dataset.order;
                    document.getElementById("statusModal").style.display = "block";
                });
            });

            document.querySelector(".close").addEventListener("click", function() {
                document.getElementById("statusModal").style.display = "none";
            });
        });
    </script>


</body>

</html>