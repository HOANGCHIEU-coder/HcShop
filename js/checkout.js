document
  .getElementById("viewOrderButton")
  .addEventListener("click", function () {
    const orderListContainer = document.getElementById("orderListContainer");

    // Kiểm tra xem danh sách đơn hàng đã hiển thị chưa
    if (orderListContainer.style.display === "none") {
      orderListContainer.style.display = "block"; // Hiển thị danh sách đơn hàng

      // Gửi yêu cầu AJAX để lấy dữ liệu
      const xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        "/HCShopTest/public/CheckoutController/orderHistory",
        true
      );
      // Đổi sang file PHP của bạn
      xhr.onload = function () {
        if (xhr.status === 200) {
          // Chèn dữ liệu trả về vào container
          orderListContainer.innerHTML = xhr.responseText;
        } else {
          orderListContainer.innerHTML = "Không thể tải đơn hàng.";
        }
      };
      xhr.onerror = function () {
        orderListContainer.innerHTML = "Không thể tải đơn hàng.";
      };
      xhr.send();
    } else {
      // Nếu đã hiển thị, ẩn nó
      orderListContainer.style.display = "none";
    }
  });
