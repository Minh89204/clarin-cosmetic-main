<?php
session_start();
include '../db.php'; // Đảm bảo file kết nối cơ sở dữ liệu được bao gồm
$total_quantity = 0; // Khởi tạo giá trị mặc định

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_quantity += $item['quantity']; // Tính tổng số lượng sản phẩm trong giỏ hàng
    }
}
// Kiểm tra đăng nhập
$is_logged_in = isset($_SESSION['user_id']);
$user_name = 'Người dùng'; // Giá trị mặc định nếu không tìm thấy tên

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_name = htmlspecialchars($row['name']); // Lấy tên từ cột 'name'
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Clarins Cosmetic</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <!-- Thanh điều hướng -->
        <nav class="navbar">
            <div class="container">
                <ul class="navbar-links">
                    <li><a href="index.php">Trang Chủ</a></li>
                    <li><a href="featured_products.php">Sản phẩm bán chạy</a></li>

                </ul>
                <a href="index.php" class="logo">
                    <img src="../images/logo.png" alt="Clarins Logo" class="logo-img">
                </a>
                <div class="navbar-icons">
                    <?php if ($is_logged_in): ?>
                        <span class="user-greeting">
                            Xin chào, <?= $user_name ?>!
                        </span>
                        <a href="../logout.php" class="icon"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                    <?php else: ?>
                        <a href="../login.php" class="icon"><i class="fas fa-user"></i> Đăng nhập</a>
                        <a href="../register.php" class="icon"><i class="fas fa-user-plus"></i> Đăng ký</a>
                    <?php endif; ?>
                    <a href="javascript:void(0);" class="icon" onclick="openCartPopup()">
                        <i class="fas fa-shopping-cart"></i> Giỏ hàng (<?= $total_quantity ?>)
                    </a>
                </div>
            </div>
        </nav>

        <!-- <nav class="navbar">
        <div class="container">
            <div class="header-search-bar">
                <form class="search-form" role="search" action="/search.php" method="get">
                    <input type="text" name="q" class="search-input" placeholder="Search" required>
                    <button type="submit" class="search-btn">
                        <svg width="22" height="22" fill="none" stroke="#333" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </button>
                </form>
            </div>
            <a href="index.php" class="logo">
                <img src="../images/logo.png" alt="Clarins Logo" class="logo-img">
            </a>
            <nav class="main-menu">
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="featured_products.php">Sản phẩm bán chạy</a></li>
                    <li><a href="new_arrivals.php">Sản phẩm mới</a></li>
                </ul>
            </nav>

            <div class="navbar-icons">
                <?php if ($is_logged_in): ?>
                    <span class="user-greeting">
                        Xin chào, <?= $user_name ?>!
                    </span>
                    <a href="../logout.php" class="icon"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                <?php else: ?>
                    <a href="../login.php" class="icon"><i class="fas fa-user"></i> Đăng nhập</a>
                    <a href="../register.php" class="icon"><i class="fas fa-user-plus"></i> Đăng ký</a>
                <?php endif; ?>
                <a href="javascript:void(0);" class="icon" onclick="openCartPopup()">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng (<?= $total_quantity ?>)
                </a>
            </div>
        </div>
    </nav> -->

    </header>

    <main>
        <div class="banner-container">
            <img src="../images/main.png" alt="Banner Clarins">
        </div>
        <section class="expertise-section">
            <h2 class="expertise-title">Your skin. Our expertise.</h2>
            <p class="expertise-desc">DISCOVER OUR PLANT-POWERED FORMULAS</p>
            <div class="expertise-categories">
                <div class="expertise-item">
                    <img src="../images/face.png" alt="Face" class="expertise-img">
                    <div class="expertise-label">FACE</div>
                    <a href="#" class="expertise-link">SHOP NOW</a>
                </div>
                <div class="expertise-item">
                    <img src="../images/makeup.png" alt="Makeup" class="expertise-img">
                    <div class="expertise-label">MAKEUP</div>
                    <a href="#" class="expertise-link">SHOP NOW</a>
                </div>
                <div class="expertise-item">
                    <img src="../images/body.png" alt="Body" class="expertise-img">
                    <div class="expertise-label">BODY</div>
                    <a href="#" class="expertise-link">SHOP NOW</a>
                </div>
                <div class="expertise-item">
                    <img src="../images/men.png" alt="Men" class="expertise-img">
                    <div class="expertise-label">MEN</div>
                    <a href="#" class="expertise-link">SHOP NOW</a>
                </div>
            </div>
        </section>


        <!-- Sản phẩm -->
        <section class="featured-products">
            <!-- Vòng lặp PHP có thể thay thế các sản phẩm cố định dưới đây -->

            <div class="product-item">
                <img src="../images/body1.jpg" alt="Sản phẩm 1" class="product-img">
                <p class="product-name">Sản phẩm 1</p>
                <p class="product-price">500,000 VNĐ</p>
                <a href="product_detail.php?id=1" class="view-detail-btn">Xem chi tiết</a>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="id" value="1">
                    <input type="hidden" name="name" value="Sản phẩm 1">
                    <input type="hidden" name="price" value="500000">
                    <input type="hidden" name="image" value="../images/body1.jpg">
                    <button type="submit" name="add_to_cart" class="buy-now-btn">Mua ngay</button>
                </form>
            </div>

            <div class="product-item">
                <img src="../images/serum1.jpeg" alt="Sản phẩm 2" class="product-img">
                <p class="product-name">Sản phẩm 2</p>
                <p class="product-price">700,000 VNĐ</p>
                <a href="product_detail.php?id=2" class="view-detail-btn">Xem chi tiết</a>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="id" value="2">
                    <input type="hidden" name="name" value="Sản phẩm 2">
                    <input type="hidden" name="price" value="700000">
                    <input type="hidden" name="image" value="../images/serum1.jpeg">
                    <button type="submit" name="add_to_cart" class="buy-now-btn">Mua ngay</button>
                </form>
            </div>

            <div class="product-item">
                <img src="../images/uv.jpg" alt="Sản phẩm 3" class="product-img">
                <p class="product-name">Sản phẩm 3</p>
                <p class="product-price">700,000 VNĐ</p>
                <a href="product_detail.php?id=3" class="view-detail-btn">Xem chi tiết</a>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="id" value="3">
                    <input type="hidden" name="name" value="Sản phẩm 3">
                    <input type="hidden" name="price" value="700000">
                    <input type="hidden" name="image" value="../images/uv.jpg">
                    <button type="submit" name="add_to_cart" class="buy-now-btn">Mua ngay</button>
                </form>
            </div>
        </section>

        <section class="why-earthly-section">
            <h2 class="why-earthly-title">Why Earthly?</h2>
            <div class="why-earthly-content">
                <div class="why-earthly-text">
                    <p>shop 6,000+ wholesome skincare, organic products and beauty product curated just for 22+ middle to high income background womens.</p>
                    <p>we offering beauty products and essential skincare items for women made from purely natural ingredients, taken from the earth’s crust.</p>
                    <p>we are provide their customers with products made out of 100% natural ingredients with no side effects unlike their competitors.</p>
                </div>
                <div class="why-earthly-image">
                    <img src="../images/good-skin-club.png" alt="Good Skin Club">
                </div>
            </div>
        </section>

        <section class="instagram-section">
            <h2 class="instagram-title">Products and discounts on Instagram</h2>
            <div class="instagram-gallery">
                <img src="../images/insta1.jpg" alt="Instagram 1">
                <img src="../images/insta2.jpg" alt="Instagram 2">
                <img src="../images/insta3.jpg" alt="Instagram 3">
                <img src="../images/insta4.jpg" alt="Instagram 4">
                <img src="../images/insta5.jpg" alt="Instagram 5">
                <img src="../images/insta6.jpg" alt="Instagram 6">
            </div>
        </section>
    </main>

    <!-- Hero -->
    <div class="hero" style="background-image: url('images/background.jpg');">
        <h1>Chào mừng đến với Clarins Cosmetic</h1>
        <p>Khám phá các sản phẩm mỹ phẩm cao cấp cho sắc đẹp của bạn.</p>
    </div>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <footer class="footer py-5">
        <div class="container">
            <div class="row">
                <!-- Customer Service -->
                <div class="col-md-3 mb-4">
                    <h6 class="fw-bold">Customer Service</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php">Our Story</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="track_order.php">Track My Order</a></li>
                        <li><a href="shipping_policy.php">Shipping Policy</a></li>
                    </ul>
                </div>
            </div>

            <hr>

            <div class="text-center mb-3">
                <a href="https://www.visa.com/" target="_blank" rel="noopener">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" width="40" class="mx-2">
                </a>
                <a href="https://www.mastercard.com/" target="_blank" rel="noopener">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard" width="40" class="mx-2">
                </a>
                <a href="https://www.americanexpress.com/" target="_blank" rel="noopener">
                    <img src="https://www.svgrepo.com/show/122382/american-express-logo.svg" alt="American Express" width="40" class="mx-2">
                </a>
                <a href="https://www.discover.com/" target="_blank" rel="noopener">
                    <img src="https://cdn.worldvectorlogo.com/logos/discover-card.svg" alt="Discover" width="40" class="mx-2">
                </a>
                <a href="https://www.paypal.com/" target="_blank" rel="noopener">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" width="40" class="mx-2">
                </a>
                <a href="https://www.apple.com/apple-pay/" target="_blank" rel="noopener">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple Pay" width="40" class="mx-2">
                </a>
                <a href="https://www.afterpay.com/" target="_blank" rel="noopener">
                    <img src="https://cdn.worldvectorlogo.com/logos/afterpay.svg" alt="Afterpay" width="40" class="mx-2">
                </a>
            </div>

            <p class="text-center text-muted">&copy; 2025 Clarins USA. All rights reserved.</p>
        </div>
    </footer>



    <!-- Popup Cart -->
    <div id="cartPopup" class="popup" style="display:none;">
        <div class="popup-content" id="popupContent"></div>
        <span class="close" onclick="closeCartPopup()">&times;</span>
    </div>

    <!-- JS -->
    <script>
        // Mở popup
        function openCartPopup() {
            fetch('cart.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('popupContent').innerHTML = html;
                    document.getElementById('cartPopup').style.display = 'flex';
                });
        }

        // Đóng popup
        function closeCartPopup() {
            document.getElementById('cartPopup').style.display = 'none';
        }

        // Nếu click ra ngoài popup-content thì đóng popup
        window.addEventListener('click', function(event) {
            var popup = document.getElementById('cartPopup');
            var popupContent = document.getElementById('popupContent');
            if (event.target === popup) {
                closeCartPopup();
            }
        });
    </script>

    <!-- CSS Popup -->
    <style>
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: #fff;
            padding: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 80%;
            overflow-y: auto;
            position: relative;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
        }
    </style>

</body>

</html>