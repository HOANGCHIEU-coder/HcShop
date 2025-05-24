<?php
require_once __DIR__ . '/../config/session_config.php';?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['name']; ?> - Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="/HCShopTest/styles/single_styles.css">
    <link rel="stylesheet" href="/HCShopTest/styles/detail.css">
    <link rel="stylesheet" href="/HCShopTest/styles/bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="/HCShopTest/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="super_container">

        <!-- Header -->

        	<header class="header trans_300">

        		<!-- Top Navigation -->

        		<div class="top_nav">
                    <div class="container">
                    	<div class="row">
                    		<div class="col-md-6">
                    		    <div class="top_nav_left">Chào Mừng Bạn Đến Với Shop Bán Quần Áo Của HC_Shop !!!</div>
                    		</div>
                    			<div class="col-md-6 text-right">
                    			    <div class="top_nav_right">
                    					<ul class="top_nav_menu">
                                            <li class="account">
                                                <a href="#">My Account <i class="fa fa-angle-down"></i></a>
                                                <ul class="account_selection">
                                                    <li id="userGreeting" style="display: <?php echo isset($_SESSION['user_id']) ? 'block' : 'none'; ?>">
                                                        <a href="#"><i class="fa fa-user"></i> Xin chào <?php echo $_SESSION['user_name'] ?? ''; ?></a>
                                                    </li>
                                                    <li id="logoutLi" style="display: <?php echo isset($_SESSION['user_id']) ? 'block' : 'none'; ?>">
                                                        <a href="/HCShopTest/public/AuthController/logout" id="logoutBtn"><i class="fa fa-sign-out"></i> Logout</a>
                                                    </li>
                                                    <li id="loginLi" style="display: <?php echo isset($_SESSION['user_id']) ? 'none' : 'block'; ?>">
                                                        <a href="login.php"><i class="fa fa-sign-in"></i> Sign In</a>
                                                    </li>
                                                    <li id="registerLi" style="display: <?php echo isset($_SESSION['user_id']) ? 'none' : 'block'; ?>">
                                                        <a href="register.php"><i class="fa fa-user-plus"></i> Register</a>
                                                    </li>
                                                </ul>
                                        </li>
                                    </ul>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                </div>

        		<!-- Main Navigation -->

        		<div class="main_nav_container">
        			<div class="container">
        				<div class="row">
        					<div class="col-lg-12 text-right">
        						<div class="logo_container">
        							<a href="#">HC <span>shop</span></a>
        						</div>
        						<nav class="navbar">
        							<ul class="navbar_menu">
        								<li><a href="/HCShopTest/public/HomeController/index">home</a></li>
        								<li><a href="/HCShopTest/public/ContactController/index">contact</a></li>
        							</ul>

        						 <ul>
        						<ul class="navbar_user">
        							 <li class="checkout">
        								  <a href="/HCShopTest/public/CartController/index">
        									  <i class="fa fa-shopping-cart" aria-hidden="true"></i>
        								  </a>
        							 </li>
        							 </ul>
        						</nav>
        					</div>
        				</div>
        			</div>
        		</div>

        	</header><br><br>


        <div class="container mt-5 product-detail-wrapper">
            <div class="row gx-5 align-items-start">
                <!-- ảnh sản phẩm -->
                <?php
                $image_main = $product['image'];
                $image_alt = str_replace('.png', 'b.png', $image_main);
                ?>

                <div class="col-md-6">
                    <div class="product-gallery text-center">
                        <div class="image-viewer position-relative">
                            <button class="nav-btn left" onclick="prevImage()">&#10094;</button>
                            <img id="mainImage" src="/HCShopTest/public/images/<?php echo $image_main; ?>" class="main-img">
                            <button class="nav-btn right" onclick="nextImage()">&#10095;</button>
                        </div>

                        <div class="thumbnail-row mt-3 d-flex justify-content-center gap-2">
                            <img class="thumb-img active-thumb" src="/HCShopTest/public/images/<?php echo $image_main; ?>" onclick="setImage(0)">
                            <img class="thumb-img" src="/HCShopTest/public/images/<?php echo $image_alt; ?>" onclick="setImage(1)">
                        </div>
                    </div>
                </div>


            <!-- Cột phải: Thông tin sản phẩm -->
            <div class="col-md-6 product-info ms-4">
                <h2 class="mb-3"><?php echo $product['name']; ?></h2>

                <?php
                    $price = (int)$product['price'];
                    $discount = (int) ($product['discount'] ?? 0);
                    $final_price = $discount > 0 ? $price - ($price * $discount / 100) : $price;
                ?>

                <p class="fs-5 fw-semibold text-danger">
                    <?php echo number_format($final_price, 0, ',', '.'); ?>₫
                </p>

                <?php if ($discount > 0): ?>
                    <p class="text-muted">
                    <del><?php echo number_format($price, 0, ',', '.'); ?>₫</del> (-<?php echo $discount; ?>%)
                </p>
                <?php endif; ?>

                <p class="text-muted"><?php echo $product['description']; ?></p>

                <!-- Chọn size -->
                <?php
                    $sizes = isset($product['sizes']) ? explode(',', $product['sizes']) : ['S', 'M', 'L', 'XL'];
                ?>
                <!-- Chọn kích thước -->
                <div class="sizes mb-3">
                    <label class="form-label">Kích thước:</label>
                    <div class="d-flex gap-2 flex-wrap">
                    <?php foreach ($sizes as $size): ?>
                    <?php $stock = $stockBySize[$size] ?? 0; ?>
                        <button type="button"
                            class="size-box btn btn-outline-dark px-3 py-2"
                            onclick="selectSize(this)"
                            data-size="<?php echo $size; ?>"
                            <?php echo $stock === 0 ? 'disabled style="opacity:0.5;"' : ''; ?>>
                        <?php echo $size . " (" . $stock . ")"; ?>
                        </button>
                    <?php endforeach; ?>
                    </div>
                    <input type="hidden" id="selectedSize" name="size" required>
                </div>

                <!-- Số lượng -->
                <div class="quantity-control d-flex align-items-center gap-2 mb-3">
                <label>Số lượng:</label>
                <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(-1)">−</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control text-center" style="width: 60px;">
                <button type="button" class="btn btn-outline-secondary" onclick="updateQuantity(1)">+</button>
                </div>

                <!-- Nút mua -->
                <input type="hidden" id="productId" value="<?php echo $product['id']; ?>"> <!-- Gán id sản phẩm ẩn -->
                <button class="btn btn-danger w-100 mb-2" onclick="handleAddToCart()">🛒 Thêm vào giỏ hàng</button>
                <button class="btn btn-dark w-100" onclick="handleBuyNow()">MUA NGAY</button>


                <!-- Thông tin thêm -->
                <div class="extra-info mt-4">
                    <p><strong>Kiểu dáng:</strong> <?php echo $product['style'] ?? 'Đang cập nhật'; ?></p>
                    <p><strong>Chất liệu:</strong> <?php echo $product['material'] ?? 'Đang cập nhật'; ?></p>
                </div>
            </div>

        </div>
    </div>

</div>



<script>
  window.images = [
    "/HCShopTest/public/images/<?php echo $image_main; ?>",
    "/HCShopTest/public/images/<?php echo $image_alt; ?>"
  ];
</script>
<script>
  const stockBySize = <?php echo json_encode($stockBySize); ?>;
</script>

<script src="/HCShopTest/js/chitietsp.js"></script>
<script src="/HCShopTest/js/detail.js"></script>
<script src="/HCShopTest/js/jquery-3.2.1.min.js"></script>
<script src="/HCShopTest/styles/bootstrap4/popper.js"></script>
<script src="/HCShopTest/styles/bootstrap4/bootstrap.min.js"></script>
<script>
function handleBuyNow() {
    const productId = document.getElementById('productId').value;
    const size = document.getElementById('selectedSize').value;
    const quantity = document.getElementById('quantity').value;

    if (!size) {
        alert('Vui lòng chọn size!');
        return;
    }

    $.ajax({
        url: '/HCShopTest/public/CartController/buyNow',
        method: 'POST',
        data: {
            product_id: productId,
            size: size,
            quantity: quantity
        },
        success: function(res) {
            // Sau khi lưu thành công, chuyển sang trang checkout
            window.location.href = '/HCShopTest/public/CheckoutController/index?mode=buy_now';
        },
        error: function() {
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        }
    });
}
</script>
</body>
</html>