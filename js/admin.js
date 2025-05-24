$(document).ready(function(){
    // Khi người dùng click vào "Quản lý sản phẩm"
    $('#manage-products').on('click', function(){
        // Chuyển nội dung trong phần #content
        $('#content').html('<h2>Danh sách sản phẩm</h2><table border="1"><thead><tr><th>ID</th><th>Tên sản phẩm</th><th>Giá</th><th>Hành động</th></tr></thead><tbody><tr><td>1</td><td>Sản phẩm A</td><td>100,000 VND</td><td><a href="#">Sửa</a> | <a href="#">Xóa</a></td></tr><tr><td>2</td><td>Sản phẩm B</td><td>200,000 VND</td><td><a href="#">Sửa</a> | <a href="#">Xóa</a></td></tr></tbody></table>');
    });

    // Khi người dùng click vào các menu khác
    $('#manage-orders').on('click', function(){
        $('#content').html('<h2>Danh sách đơn hàng</h2><p>Danh sách các đơn hàng sẽ hiển thị ở đây.</p>');
    });

    $('#manage-users').on('click', function(){
        $('#content').html('<h2>Danh sách người dùng</h2><p>Danh sách người dùng sẽ hiển thị ở đây.</p>');
    });

    $('#sales-report').on('click', function(){
        $('#content').html('<h2>Báo cáo doanh thu</h2><p>Thông tin báo cáo doanh thu sẽ hiển thị ở đây.</p>');
    });
});
