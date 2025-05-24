function deleteProduct(id) {
    if (confirm("Bạn có chắc muốn xóa sản phẩm này không?")) {
        fetch("admin_dashboard.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "delete_product_id=" + id
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === "success") {
                alert("Đã xóa sản phẩm!");
                location.reload();
            } else {
                alert("Có lỗi xảy ra khi xóa sản phẩm!");
                console.error(result); // hiện chi tiết lỗi nếu cần
            }
        })
        .catch(error => {
            console.error("Lỗi fetch:", error);
        });
    }
}
