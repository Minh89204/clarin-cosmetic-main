<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();


    
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        if ($_SESSION['role'] === 'admin') {
            header("Location: public/index.php");
        } else {
            header("Location: public/index.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Email hoặc mật khẩu không đúng.";
        header("Location: login.php");
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập - Clarins Cosmetic</title>
    <link rel="stylesheet" href="style.css"> <!-- Link file CSS -->
</head>

<body>

    <div class="login-container">
        <h2>Đăng nhập tài khoản</h2>

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
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Nhập email">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
            </div>

            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>
    </div>

</body>

</html>