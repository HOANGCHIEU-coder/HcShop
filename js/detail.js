/****phần js chuyển ảnh ****/
document.addEventListener("DOMContentLoaded", function () {
  // Kiểm tra xem biến images có tồn tại không
  if (typeof window.images === "undefined" || !window.images.length) {
    console.warn("Biến images không tồn tại hoặc rỗng.");
    return;
  }

  let currentIndex = 0;

  function updateMainImage() {
    const mainImage = document.getElementById("mainImage");
    if (!mainImage) return;

    mainImage.src = window.images[currentIndex];

    document.querySelectorAll(".thumb-img").forEach((img, index) => {
      img.classList.toggle("active-thumb", index === currentIndex);
    });
  }

  // Gán các hàm vào window để gọi được từ HTML onclick
  window.prevImage = function () {
    currentIndex =
      (currentIndex - 1 + window.images.length) % window.images.length;
    updateMainImage();
  };

  window.nextImage = function () {
    currentIndex = (currentIndex + 1) % window.images.length;
    updateMainImage();
  };

  window.setImage = function (index) {
    currentIndex = index;
    updateMainImage();
  };

  // Khởi động lần đầu
  updateMainImage();
});

/******** phần chọn size*********/
function selectSize(button) {
  // Bỏ chọn tất cả các nút size
  document.querySelectorAll(".size-box").forEach((btn) => {
    btn.classList.remove("btn-dark");
    btn.classList.add("btn-outline-dark");
  });

  // Đánh dấu nút vừa chọn
  button.classList.remove("btn-outline-dark");
  button.classList.add("btn-dark");

  // Lưu vào input ẩn
  document.getElementById("selectedSize").value = button.dataset.size;
}

/** Phần JS cho nút MUA NGAY **/
function handleBuyNow() {
  window.location.href =
    "/HCShopTest/public/CheckoutController/index?mode=buy_now";
}
