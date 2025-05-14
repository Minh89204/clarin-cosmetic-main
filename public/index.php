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

<!-- Thanh điều hướng -->
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">
            <img src="../images/logo.png" alt="Clarins Logo" class="logo-img">
        </a>
        <ul class="navbar-links">
            <li><a href="index.php">Trang Chủ</a></li>
            <li><a href="featured_products.php">Sản phẩm bán chạy</a></li>
            <li><a href="product_gallery.php">Thư viện ảnh</a></li>
            <li><a href="contact_us.php">Liên hệ</a></li>
        </ul>
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


<!-- Hero -->
<div class="hero" style="background-image: url('images/background.jpg');">
    <h1>Chào mừng đến với Clarins Cosmetic</h1>
    <p>Khám phá các sản phẩm mỹ phẩm cao cấp cho sắc đẹp của bạn.</p>
</div>

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

<!-- Footer -->
<footer class="footer">
    <p>&copy; 2025 Clarins Cosmetic. All rights reserved.</p>
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
    top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.6);
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
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
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
