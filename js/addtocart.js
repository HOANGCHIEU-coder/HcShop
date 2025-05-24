function addToCart(id) {
  const size = document.getElementById("modalSize").value;
  const quantity = document.getElementById("modalQuantity").value;

  fetch("/HcShop/add_to_cart.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: new URLSearchParams({
      product_id: id,
      size: size,
      quantity: quantity
    })
  })



  .then(res => res.json())
  .then(data => {
    if (data.status === "unauthorized") {
      alert(data.message);
      window.location.href = "login.php?next=index.php";
      return;
    }

    if (data.status === "fail") {
      alert(data.message);
      return;
    }

    if (data.status === "success") {
      alert("✅ Đã thêm sản phẩm vào giỏ hàng!");
    }
  });
}
