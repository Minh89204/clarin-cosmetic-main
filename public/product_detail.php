<?php
session_start();
include '../db.php';

// Lấy id sản phẩm từ URL và lọc dữ liệu để tránh SQL Injection
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra nếu id hợp lệ
if ($product_id <= 0) {
    die("Sản phẩm không tồn tại.");
}

// Truy vấn thông tin sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

// Kiểm tra nếu có sản phẩm
if (!$product) {
    die("Sản phẩm không tồn tại.");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - Clarins</title>
    <link rel="stylesheet" href="../style.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #343a40;
    }
    h2 {
        margin-top: 20px;
    }
    a {
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
<body>

<h2 style="text-align: center; color: #b30059;">Chi tiết sản phẩm</h2>

<div style="text-align: center; max-width: 900px; margin: 0 auto; padding: 20px;">
    <h3><?= htmlspecialchars($product['name']) ?></h3>
    <img src="../images/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; max-width: 300px; margin-bottom: 20px;">
    <p><strong>Mô tả:</strong> <?= nl2br(htmlspecialchars($product['description'])) ?></p>
    <p><strong>Giá:</strong> <?= number_format($product['price'], 0, ',', '.') ?> đ</p>

    <a href="cart.php?action=add&id=<?= $product['product_id'] ?>" style="text-decoration: none; background-color: #d63384; color: #fff; padding: 10px 20px; border-radius: 5px;">Thêm vào giỏ hàng</a>
</div>

</body>
</html>
