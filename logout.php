<?php
session_start();

// Xóa tất cả dữ liệu trong session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng về trang chủ (index.php trong thư mục public)
header("Location: /clarins_cosmetic/public/index.php");
exit();
?>
