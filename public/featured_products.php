<?php
session_start();
include '../db.php';

// Truy vấn các sản phẩm bán chạy
$sql = "SELECT * FROM products WHERE is_top_selling = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản phẩm bán chạy - Clarins</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2 style="text-align: center; color: #b30059;">Sản phẩm bán chạy</h2>
    <div class="product-list" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; padding: 20px;">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-item" style="width: 250px; border: 1px solid #ddd; padding: 10px; text-align: center; border-radius: 8px;">
                    <img src="../images/<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="width: 100%; height: auto;">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <p><?= number_format($row['price'], 0, ',', '.') ?> đ</p>
                    <a href="product_detail.php?id=<?= $row['product_id'] ?>" class="view-detail-btn">Xem chi tiết</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Không có sản phẩm bán chạy nào.</p>
        <?php endif; ?>
    </div>
</body>
</html>
