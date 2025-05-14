<?php
session_start();

// // Kiểm tra nếu người dùng không phải admin thì chuyển hướng về trang chủ
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
//     header('Location: index.php');
//     exit;
// }

// include '../db.php'; // Include database connection

// // Kiểm tra nếu form được submit
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $name = $_POST['name'];
//     $price = $_POST['price'];
//     $description = $_POST['description'];
//     $image = $_FILES['image']['name'];

//     // Di chuyển file ảnh tải lên
//     $image_path = 'images/products/' . basename($image);
//     move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

//     // Thêm sản phẩm vào cơ sở dữ liệu
//     $sql = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$image_path')";
//     if (mysqli_query($conn, $sql)) {
//         header('Location: index.php'); // Quay lại trang index sau khi thêm sản phẩm
//         exit;
//     } else {
//         echo "Lỗi khi thêm sản phẩm: " . mysqli_error($conn);
//     }
// }

// ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sản Phẩm</title>
    <link rel="stylesheet" href="../admin/css/admin-style.css">
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h1>Thêm Sản Phẩm Mới</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Tên sản phẩm</label>
        <input type="text" id="name" name="name" required>

        <label for="price">Giá</label>
        <input type="text" id="price" name="price" required>

        <label for="description">Mô tả</label>
        <textarea id="description" name="description" required></textarea>

        <label for="image">Ảnh sản phẩm</label>
        <input type="file" id="image" name="image" required>

        <button type="submit">Thêm sản phẩm</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>
