<?php
require_once __DIR__ . '/../config/session_config.php';
require_once __DIR__ . '/../core/Database.php';

$db = new Database();
$conn = $db->getConnection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Colo Shop</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Colo Shop Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="/HCShopTest/styles/bootstrap4/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/plugins/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/css/glide.core.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<link rel="stylesheet" type="text/css" href="/HCShopTest/styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/styles/responsive.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/styles/nutaddtocart.css">
<link rel="stylesheet" type="text/css" href="/HCShopTest/styles/sanpham.css">
	
	

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
    						<div class="top_nav_left">💖💖Chào Mừng Bạn Đến Với HC_Shop 💖💖</div>
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
                                                <a href="#" id="logoutBtn"><i class="fa fa-sign-out"></i> Logout</a>
                                            </li>
                                            <li id="loginLi" style="display: <?php echo isset($_SESSION['user_id']) ? 'none' : 'block'; ?>">
                                                <a href="/HCShopTest/public/LoginController/index"><i class="fa fa-sign-in"></i> Sign In</a>
                                            </li>
                                            <li id="registerLi" style="display: <?php echo isset($_SESSION['user_id']) ? 'none' : 'block'; ?>">
                                                <a href="/HCShopTest/public/RegisterController/index"><i class="fa fa-user-plus"></i> Register</a>
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
    							<!-- thanh tìm kiếm  -->
    							 <ul>
    								 <form action="index.php" method="get" style="display: inline;">
    									 <input type="text" name="search" placeholder="🔍Tìm sản phẩm..." style="padding: 5px;">
    								 </form>
    							 </ul>
    						 <ul>
    						<ul class="navbar_user">
    							 <li class="checkout">
    								  	<a href="/HCShopTest/public/CartController/index">
											<i class="fa fa-shopping-cart"></i>
										</a>
    							 </li>
    							 </ul>
    						</nav>
    					</div>
    				</div>
    			</div>
    		</div>

    	</header>

    <br><br><br><br><br>
	<div class="fs_menu_overlay"></div>
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li class="menu_item has-children">
					<a href="#">
						My Account
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="menu_selection">
						<li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
						<li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a></li>
					</ul>
				</li>
				<li class="menu_item"><a href="#">home</a></li>
				<li class="menu_item"><a href="#">shop</a></li>
				<li class="menu_item"><a href="#">pages</a></li>
			</ul>
		</div>
	</div>

	<!-- Slider -->
	<div class="swiper mySlider">
	<div class="swiper-wrapper">
		<div class="swiper-slide" style="background-image:url('/HCShopTest/public/images/slider1a.jpg')">
		<div class="slider-content">
			<h1>HOT Summer Promotion 2025</h1>
			<a href="#new-arrivals" class="shop-button">Shop Now</a>
		</div>
		</div>
		<div class="swiper-slide" style="background-image:url('/HCShopTest/public/images/slider2a.jpg')">
		<div class="slider-content">
			<h1>Summer Vibes</h1>
			<a href="#new-arrivals" class="shop-button">Shop Now</a>
		</div>
		</div>
		<div class="swiper-slide" style="background-image:url('/HCShopTest/public/images/slider3a.jpg')">
		<div class="slider-content">
			<h1>New Arrivals</h1>
			<a href="#new-arrivals" class="shop-button">Shop Now</a>
		</div>
		</div>
	</div>

	<!-- Navigation -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
	<div class="swiper-pagination"></div>
	</div>


	<!-- New Arrivals -->
    <div class="new_arrivals" id="new-arrivals">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <div class="section_title new_arrivals_title">
                        <h2>New Arrivals</h2>
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
                        <div class="row align-items-center">
                            <div class="col text-center">
                                <div class="new_arrivals_sorting">
                                    <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center active is-checked" data-filter="*">
                                            All
                                        </li>
                                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".women">
                                            Women's
                                        </li>
                                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".men">
                                            Men's
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    <!-- Seach các sacnr phẩm -->

                    <?php
                    $search = '';
                    $filter = '';

                    $conditions = [];

                    if (isset($_GET['search']) && trim($_GET['search']) !== '') {
                        $search = trim($_GET['search']);
                        $search_safe = mysqli_real_escape_string($conn, $search);
                        $conditions[] = "LOWER(name) LIKE LOWER('%$search_safe%')";
                    }

                    if (isset($_GET['filter']) && in_array($_GET['filter'], ['women', 'men'])) {
                        $filter = $_GET['filter'];
                        $conditions[] = "LOWER(category) = '$filter'";
                    }

                    $where = '';
                    if (!empty($conditions)) {
                        $where = 'WHERE ' . implode(' AND ', $conditions);
                    }

                    $sql = "SELECT * FROM products $where";
                    $result = $conn->query($sql);
                    ?>

        <?php if (!empty($search)): ?>
                    <h3>Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($search); ?>"</h3>
                <?php endif; ?>

                <!--Danh sách các sản phẩm -->
            <div class="product-wrapper">
                <section class="product-section"> <br>
                    <div class="product-grid">
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <?php
                                    $id = (int)$product['id'];
                                    $name = htmlspecialchars($product['name']);
                                    $image = htmlspecialchars($product['image']);
                                    $label = strtolower($product['label']);
                                    $category = strtolower($product['category']);
                                    $price = (int)$product['price'];
                                    $discount = (int)$product['discount'];
                                    $final_price = $discount > 0 ? $price - ($price * $discount / 100) : $price;
                                ?>
                                <div class="product-card <?php echo $category; ?>">
                                    <a href="/HCShopTest/public/ProductController/detail?id=<?php echo $id; ?>" class="product-image-box">
                                        <img src="/HCShopTest/public/images/<?php echo $image; ?>" alt="<?php echo $name; ?>">
                                        <?php if ($label === 'sale'): ?>
                                            <div class="product-tag sale">SALE</div>
                                        <?php elseif ($label === 'new'): ?>
                                            <div class="product-tag new">NEW</div>
                                        <?php endif; ?>
                                    </a>
                                    <div class="product-info">
                                        <h4 class="product-title"><?php echo $name; ?></h4>
                                        <div class="product-price">
                                            <?php if ($discount > 0): ?>
                                                <span class="final"><?php echo number_format($final_price, 0, ',', '.'); ?>₫</span>
                                                <del class="original"><?php echo number_format($price, 0, ',', '.'); ?>₫</del>
                                            <?php else: ?>
                                                <span class="final"><?php echo number_format($price, 0, ',', '.'); ?>₫</span>
                                            <?php endif; ?>
                                        </div>
                                        <button class="red_button add_to_cart_btn"
                                            onclick="openModal(<?php echo $id; ?>, '<?php echo addslashes($image); ?>', '<?php echo addslashes($name); ?>')">
                                            🛒 Thêm vào giỏ
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Không có sản phẩm nào.</p>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

        <!-- Modal chọn size -->
        <div id="sizeModal" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Chọn size sản phẩm</h3>
            <form id="modalAddToCartForm" onsubmit="submitModalForm(event)">
              <input type="hidden" id="modal-product-id">
              <select id="modal-size-select" required>
                <option value="" disabled selected>Chọn size</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
              </select>
              <button type="submit">🛒 Xác nhận</button>
            </form>
          </div>
        </div>



	    <div class="deal_ofthe_week">
    		<div class="container">
    			<div class="row align-items-center">
    				<div class="col-lg-6">
    					<div class="deal_ofthe_week_img">
    						<img src="/HCShopTest/public/images/img_1.png" class="transparent-image" alt="Flash Sale Girl">
    					</div>
    				</div>
    				<div class="col-lg-6 text-right deal_ofthe_week_col">
    					<div class="deal_ofthe_week_content d-flex flex-column align-items-center float-right">
    						<div class="section_title">
    							<h2>Flash Sale</h2>
    						</div>
    						<ul class="timer">
    							<li class="d-inline-flex flex-column justify-content-center align-items-center">
    								<div id="day" class="timer_num">03</div>
    								<div class="timer_unit">Ngày</div>
    							</li>
    							<li class="d-inline-flex flex-column justify-content-center align-items-center">
    								<div id="hour" class="timer_num">15</div>
    								<div class="timer_unit">Giờ</div>
    							</li>
    							<li class="d-inline-flex flex-column justify-content-center align-items-center">
    								<div id="minute" class="timer_num">45</div>
    								<div class="timer_unit">Phút</div>
    							</li>
    							<li class="d-inline-flex flex-column justify-content-center align-items-center">
    								<div id="second" class="timer_num">23</div>
    								<div class="timer_unit">Giây</div>
    							</li>
    						</ul>
    						<div class="red_button deal_ofthe_week_button"><a href="#new-arrivals">shop now</a></div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>



	<!-- Benefit -->

	<div class="benefit">
		<div class="container">
			<div class="row benefit_row">
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Free Ship </h6>
							<p>Mọi đơn giao hàng </p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>cơ hội hoàn tiền</h6>
							<p>Hoàn tiền lên tới 100%</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Lỗi 1 đổi 1 </h6>
							<p>Hoàn trả trong vòng 30 ngày</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>mở cửa cả tuần</h6>
							<p>8:30AM - 09PM</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Blogs -->

	<div class="blogs">
		<div class="container">
			<div class="row">
				<div class="col text-center">
					<div class="section_title">
						<h2>Latest Blogs</h2>
					</div>
				</div>
			</div>
			<div class="row blogs_container">
				<div class="col-lg-4 blog_item_col">
					<div class="blog_item">
						<div class="blog_background" style="background-image:url('/HCShopTest/public/images/blog1.jpg')"></div>
						<div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
							<h4 class="blog_title">Here are the trends I see emerging this spring.</h4>
							<span class="blog_meta">by admin | Dec 01, 2025</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4 blog_item_col">
					<div class="blog_item">
						<div class="blog_background" style="background-image:url('/HCShopTest/public/images/blog2.jpg')"></div>
						<div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
							<h4 class="blog_title">Here are the trends I see emerging this summer</h4>
							<span class="blog_meta">by admin | Dec 01, 2025</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4 blog_item_col">
					<div class="blog_item">
						<div class="blog_background" style="background-image:url('/HCShopTest/public/images/blog3.jpg')"></div>
						<div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
							<h4 class="blog_title">Here are the trends I see emerging this winter</h4>
							<span class="blog_meta">by admin | Dec 01, 2025</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <hr class="separator">

	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
						<ul class="footer_nav">
							<li><a href="#">Blog</a></li>
							<li><a href="#">FAQs</a></li>
							<li><a href="contact.php">Contact us</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
						<ul>
							<li><a href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
							<li><a href="https://x.com/?lang=vi"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
							<li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="footer_nav_container">
						<div class="cr">©2025 Mọi quyền được bảo lưu. Được tạo  <i class="fa fa-heart-o" aria-hidden="true"></i> bởi <a href="#">Hoàng Chiều</a> &amp; phân phối bởi  <a href="https://themewagon.com">HcShop</a></div>
					</div>
				</div>
			</div>
		</div>
	</footer>

</div>

<div id="logoutMessage" style="
  display: none;
  position: fixed;
  top: 20px;
  right: 20px;
  background: #28a745;
  color: white;
  padding: 12px 20px;
  border-radius: 6px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  z-index: 9999;
">
  ✅ Bạn đã đăng xuất thành công!
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@glidejs/glide/dist/glide.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/isotope/3.0.6/isotope.pkgd.min.js"></script>
<script src="/HCShopTest/js/logout.js"></script>
<script src="/HCShopTest/js/jquery-3.2.1.min.js"></script>
<script src="/HCShopTest/styles/bootstrap4/popper.js"></script>
<script src="/HCShopTest/styles/bootstrap4/bootstrap.min.js"></script>
<script src="/HCShopTest/plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="/HCShopTest/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="/HCShopTest/plugins/easing/easing.js"></script>
<script src="/HCShopTest/js/custom.js"></script>
<script src="/HCShopTest/js/slider.js"></script>
<script src="/HCShopTest/js/addtocart.js"></script>
<script src="/HCShopTest/js/size.v2.js"></script>

<script>
        <?php echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/HCShopTest/js/custom.js'); ?>
    </script>
</body>
</html>
