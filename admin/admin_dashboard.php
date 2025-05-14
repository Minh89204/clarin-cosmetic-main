<?php
session_start();
include('includes/header.php');
include('includes/sidebar.php');

// Kết nối cơ sở dữ liệu
include('../db.php');

// Hàm lấy tổng số sản phẩm
function getTotalProducts($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM products");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

// Hàm lấy tổng số đơn hàng
function getTotalOrders($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders");
    $data = mysqli_fetch_assoc($result);
    return $data['total'];
}

// Hàm lấy tổng doanh thu
function getTotalRevenue($conn) {
    $result = mysqli_query($conn, "SELECT SUM(total_amount) AS revenue FROM orders");
    $data = mysqli_fetch_assoc($result);
    return $data['revenue'] ?? 0;
}
?>

<!-- Giao diện chính của Dashboard -->
<link rel="stylesheet" href="css/admin-style.css">
<script src="js/admin-script.js"></script>

<div class="main-content">
    <h1>Trang Quản Trị - Thống Kê</h1>
    <div class="dashboard-stats">
        <div class="card">
            <h2>Tổng sản phẩm</h2>
            <p><?php echo getTotalProducts($conn); ?></p>
        </div>
        <div class="card">
            <h2>Tổng đơn hàng</h2>
            <p><?php echo getTotalOrders($conn); ?></p>
        </div>
        <div class="card">
            <h2>Tổng doanh thu</h2>
            <p><?php echo number_format(getTotalRevenue($conn), 0, ',', '.') . ' VNĐ'; ?></p>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
