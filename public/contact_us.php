<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Gửi email hoặc lưu vào database
    // Ví dụ: mail($to, $subject, $message, $headers);
    
    echo "Cảm ơn bạn đã liên hệ với chúng tôi!";
}
?>

<h2>Liên hệ với chúng tôi</h2>
<form method="POST" action="">
    Tên: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Tin nhắn: <textarea name="message" required></textarea><br>
    <button type="submit">Gửi</button>
</form>

