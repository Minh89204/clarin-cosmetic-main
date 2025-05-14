<?php
session_start();
require '../db.php'; // File này chứa kết nối MySQL (ví dụ: $conn = new mysqli(...))

// Kiểm tra nếu giỏ hàng trống
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng của bạn đang trống!'); window.location.href='index.php';</script>";
    exit();
}

// Giả sử user đã đăng nhập và lưu user_id trong session
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Bạn cần đăng nhập để thanh toán!'); window.location.href='login.php';</script>";
    exit();
}

// Tính tổng tiền đơn hàng
$total_amount = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Lấy dữ liệu đơn hàng
$user_id = $_SESSION['user_id'];
$order_date = date('Y-m-d H:i:s');
$status = 'Pending'; // Hoặc 'Đang xử lý'

// Insert đơn hàng vào bảng orders
$sql = "INSERT INTO orders (user_id, order_date, total_amount, status) 
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isds", $user_id, $order_date, $total_amount, $status);

if ($stmt->execute()) {
    // Lấy id của đơn hàng vừa tạo
    $order_id = $stmt->insert_id;

    // Sau này nếu bạn có bảng order_items thì thêm sản phẩm ở đây nhé

    // Xóa giỏ hàng sau khi đặt hàng thành công
    unset($_SESSION['cart']);

    echo "<script>alert('Đặt hàng thành công! Mã đơn hàng của bạn là #$order_id'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Đặt hàng thất bại, vui lòng thử lại!'); window.location.href='index.php';</script>";
}

$stmt->close();
$conn->close();
?>
