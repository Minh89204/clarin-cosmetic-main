<?php
session_start();
include '../db.php';

// Kiểm tra xem tham số 'id' có được truyền vào URL không
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product = $conn->query("SELECT * FROM products WHERE product_id = $product_id");

    // Kiểm tra xem câu truy vấn có trả về kết quả không
    if ($product) {
        $product_details = $product->fetch_assoc();
    } else {
        echo "Không tìm thấy sản phẩm.";
        exit();
    }
} else {
    echo "Không có ID sản phẩm.";
    exit();
}
?>

<h2>Chi tiết sản phẩm</h2>
<div>
    <h3><?= $product_details['name'] ?></h3>
    <img src="<?= $product_details['image_url'] ?>" alt="<?= $product_details['name'] ?>" style="width: 100%; max-width: 300px;">
    <p><?= $product_details['description'] ?></p>
    <p>Giá: <?= $product_details['price'] ?> đ</p>
    <a href="cart.php?action=add&id=<?= $product_details['product_id'] ?>">Thêm vào giỏ hàng</a>
</div>
