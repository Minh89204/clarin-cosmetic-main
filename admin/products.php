<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h1>Danh sách sản phẩm</h1>
    <a href="add_product.php" class="btn">+ Thêm sản phẩm</a>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Ảnh</th>
            <th>Thao tác</th>
        </tr>
        <?php
        // Giả sử bạn có kết nối DB tại đây
        include '../db.php';
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['price']}</td>
                <td><img src='../uploads/{$row['image']}' width='50'></td>
                <td>
                    <a href='edit_product.php?id={$row['id']}'>Sửa</a> | 
                    <a href='delete_product.php?id={$row['id']}' class='btn-delete'>Xóa</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
