<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - HCShop</title>
    <link rel="stylesheet" type="text/css" href="/HCShopTest/styles/bootstrap4/bootstrap.min.css">
    <link href="/HCShopTest/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/HCShopTest/styles/contact_styles.css">
    <link rel="stylesheet" type="text/css" href="/HCShopTest/styles/contact_responsive.css">
</head>
<body>
<div class="super_container">

    <!-- Header (có thể include nếu tách riêng header.php) -->
    <header class="header trans_300">
        <div class="top_nav">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="top_nav_left">💖💖Chào Mừng Bạn Đến Với HC_Shop 💖💖</div>
                    </div>
                </div>
            </div>
        </div>
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
    </header>

    <!-- Breadcrumb -->
    <div class="container contact_container">
        <div class="row">
            <div class="col">
                <div class="breadcrumbs d-flex flex-row align-items-center">
                    <ul>
                        <li><a href="/HCShopTest/public/HomeController/index">Home</a></li>
                        <li class="active"><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- OpenStreetMap Container -->
            <div class="row">
                <div class="col">
                    <div id="osm_map">
                        <div class="map_container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.5791447993127!2d105.8209245154025!3d21.0101523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313453594e700953:0xdbaaf70dcbb82eb4!2zUGjDuiDEkMO0LCBOYW0gVOG7qyBMacOqbSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1616483762767"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div><br><br><br> 

        <!-- Contact Form -->
        <div class="row">
            <div class="col-lg-6 contact_col">
                <div class="contact_contents">
                    <h1>Liên hệ</h1>
                    <p>Bạn có thể liên hệ với chúng tôi qua số điện thoại, email hoặc biểu mẫu bên cạnh.</p>
                    <p>(+84) 364-081862     (Mr Hoang Chieu)</p>
                    <p>hoangchieu615@gmail.com</p>
                    <p>Giờ làm việc: 8h - 18h (Thứ Hai - Thứ Sáu)</p>
                </div>
                <div class="follow_us_contents">
                    <h1>Follow Us</h1>
                    <ul class="social d-flex flex-row">
                        <li><a href="https://facebook.com" style="background-color:#3a61c9"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://x.com" style="background-color:#41a1f6"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://google.com" style="background-color:#fb4343"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="https://instagram.com" style="background-color:#8f6247"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 get_in_touch_col">
                <div class="get_in_touch_contents">
                    <h1>Gửi lời nhắn</h1>
                    <p>Điền vào biểu mẫu dưới đây để gửi thắc mắc của bạn.</p>
                    <form method="POST" action="">
                        <input class="form_input" type="text" name="name" placeholder="Tên" required>
                        <input class="form_input" type="email" name="email" placeholder="Email" required>
                        <textarea class="form_input" name="message" placeholder="Lời nhắn" rows="4" required></textarea>
                        <button type="submit" class="red_button message_submit_btn trans_300">Gửi lời nhắn</button>
                    </form>

                    <!-- Message status -->
                    <?php if (!empty($success_message)): ?>
                        <p class="success mt-3 text-success"><?php echo $success_message; ?></p>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                        <p class="error mt-3 text-danger"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
                        <ul class="footer_nav">
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">FAQs</a></li>
                            <li><a href="/HCShopTest/public/ContactController/index">Contact us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-skype"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer_nav_container text-center">
                        <p class="cr">©2025 Mọi quyền được bảo lưu. Thiết kế bởi <b>Hoàng Chiều</b>.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>

<!-- Scripts -->
<script src="/HCShopTest/js/jquery-3.2.1.min.js"></script>
<script src="/HCShopTest/styles/bootstrap4/popper.js"></script>
<script src="/HCShopTest/styles/bootstrap4/bootstrap.min.js"></script>
<script src="/HCShopTest/plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="/HCShopTest/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="/HCShopTest/plugins/easing/easing.js"></script>
</body>
</html>
