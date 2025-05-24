// MỞ MODAL và điền thông tin sản phẩm
function editProduct(productId, size) {
    $.ajax({
        url: '/HCShopTest/public/api/get_product.php',
        type: 'GET',
        data: { id: productId, size: size },
        success: function(res) {
            const product = JSON.parse(res);

            $('#productId').val(product.id);
            $('#productSizeOld').val(product.size); // để biết size cũ
            $('#productName').val(product.name);
            $('#productPrice').val(product.price);
            $('#productSize').val(product.size);
            $('#productQuantity').val(product.quantity);
            $('#oldImage').val(product.image);

            $('#editModal').show();
        },
        error: function() {
            alert('Không lấy được thông tin sản phẩm.');
        }
    });
}

// ĐÓNG MODAL
$('.close').click(() => $('#editModal').hide());

// GỬI FORM sửa sản phẩm (không reload trang)
$('#editProductForm').submit(function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
        url: '/HCShopTest/public/api/update_product.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            alert('✅ Sửa thành công!');
            $('#editModal').hide();
            // Reload phần danh sách sản phẩm nếu muốn - hoặc:
            location.reload(); // hoặc gọi load lại qua Ajax để mượt hơn
        },
        error: function() {
            alert('❌ Cập nhật thất bại.');
        }
    });
});