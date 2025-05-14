<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $role = 'customer'; 
        $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id; // Lưu ID người dùng
            $_SESSION['username'] = $name; // Lưu tên người dùng vào session
            $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Đăng ký thất bại. Email có thể đã tồn tại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký - Clarins Cosmetic</title>
    <link rel="stylesheet" href="style.css"> <!-- Link tới CSS -->
</head>
<body>

<div class="login-container">
    <h2>Tạo tài khoản mới</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" id="name" name="name" required placeholder="Nhập tên của bạn">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="Nhập email">
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="confirm_password" required placeholder="Nhập lại mật khẩu">
        </div>

        <button type="submit" class="btn-login">Đăng ký</button>
    </form>
</div>

</body>
</html>
