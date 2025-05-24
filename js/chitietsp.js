/*** Giới hạn số lượng sản phẩm tồn kho khi click nút tăng ***/

let selectedStock = 0;

// Khi chọn size
function selectSize(btn) {
  const size = btn.getAttribute("data-size");
  document.getElementById("selectedSize").value = size;
  selectedStock = stockBySize[size] || 0;

  // Highlight
  document
    .querySelectorAll(".size-box")
    .forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");

  // Reset số lượng về 1
  document.getElementById("quantity").value = 1;
}

// Khi bấm + hoặc -
function updateQuantity(change) {
  const input = document.getElementById("quantity");
  const size = document.getElementById("selectedSize").value;

  if (!size || !(size in stockBySize)) {
    alert("Vui lòng chọn size trước!");
    return;
  }

  const max = stockBySize[size] || 0;
  let value = parseInt(input.value) || 1;

  value += change;
  if (value < 1) value = 1;
  if (value > max) value = max;

  input.value = value;
}

// Lấy dữ liệu sản phẩm từ form
function getCartData() {
  const productId = document.getElementById("productId")?.value;
  const size = document.getElementById("selectedSize")?.value;
  const quantity = parseInt(document.getElementById("quantity")?.value) || 1;
  return { productId, size, quantity };
}

// Thêm vào giỏ hàng
function handleAddToCart() {
  const { productId, size, quantity } = getCartData();

  if (!size) {
    alert("Vui lòng chọn size!");
    return;
  }

  fetch("/HCShopTest/public/CartController/add", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      product_id: productId,
      size: size,
      quantity: quantity
    }),
  })
  .then((res) => res.json())
  .then((data) => {
    console.log(data);

    if (data.status === "unauthorized") {
      alert(data.message);
      window.location.href = "/HCShopTest/public/LoginController/index?next=/ProductController/detail/" + productId;
    } else if (data.status === "fail" || data.status === "error") {
      alert(data.message);
    } else {
      alert("✅ Đã thêm vào giỏ hàng!");
    }
  })
  .catch((error) => {
    console.error("Lỗi fetch:", error);
    alert("Có lỗi xảy ra, vui lòng thử lại!");
  });
}

// MUA NGAY
function handleBuyNow() {
  const { productId, size, quantity } = getCartData();

  if (!size) {
    alert("Vui lòng chọn size để mua!");
    return;
  }

  fetch("/HCShopTest/public/index.php?url=CartController/add&mode=buy_now", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: new URLSearchParams({
      product_id: productId,
      size: size,
      quantity: quantity,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "unauthorized") {
        alert(data.message);
        window.location.href =
          "login.php?next=product_detail.php?id=" + productId;
      } else if (data.status === "fail" || data.status === "error") {
        alert(data.message);
      } else {
        // Thành công thì chuyển sang trang thanh toán chỉ với sản phẩm vừa chọn
        window.location.href = "/HCShopTest/public/CheckoutController/index";
      }
    })
    .catch(() => alert("Có lỗi xảy ra, vui lòng thử lại!"));
}
