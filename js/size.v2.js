function openModal(productId) {
  document.getElementById("modal-product-id").value = productId;
  document.getElementById("modal-size-select").value = "";
  document.getElementById("sizeModal").style.display = "block";
}

function closeModal() {
  document.getElementById("sizeModal").style.display = "none";
}

function submitModalForm(event) {
  event.preventDefault();
  const productId = document.getElementById("modal-product-id").value;
  const size = document.getElementById("modal-size-select").value;
  const button = document.querySelector("#modalAddToCartForm button");

  if (!size) {
    alert("Chọn size trước khi thêm.");
    return;
  }

  button.disabled = true;
  button.innerText = "Đang thêm...";

  fetch("http://localhost/HCShopTest/public/CartController/add", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
      "X-Requested-With": "XMLHttpRequest",
    },
    body: `product_id=${productId}&size=${encodeURIComponent(size)}`,
  })
    .then((res) => res.text()) // 👈 tạm đổi sang .text()
    .then((data) => {
      console.log("RESP:", data); // ❗ xem server trả gì
      try {
        const json = JSON.parse(data); // tự parse JSON
        if (json.status === "success") {
          button.innerText = "✅ Đã thêm!";
          setTimeout(() => {
            closeModal();
            button.disabled = false;
            button.innerText = "🛒 Xác nhận";
          }, 1000);
        } else {
          alert("Lỗi: " + (json.message || "Không rõ nguyên nhân"));
          button.disabled = false;
          button.innerText = "🛒 Xác nhận";
        }
      } catch (e) {
        console.error("Lỗi parse JSON:", e);
        alert("Phản hồi không hợp lệ từ server!");
        button.disabled = false;
        button.innerText = "🛒 Xác nhận";
      }
    })
    .catch((err) => {
      alert("Lỗi kết nối!");
      console.error(err);
      button.disabled = false;
      button.innerText = "🛒 Xác nhận";
    });
}
