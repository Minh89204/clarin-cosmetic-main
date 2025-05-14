<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
    <h1>Danh sách đơn hàng</h1>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID Đơn Hàng</th>
            <th>ID Người Dùng</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Ngày Đặt</th>
        </tr>
        <?php
        include '../db.php';  // Include database connection

        // Query to get orders with the new field names
        $sql = "SELECT * FROM orders ORDER BY order_date DESC";
        $result = mysqli_query($conn, $sql);

        // Check if the query was successful
        if (!$result) {
            die('Query failed: ' . mysqli_error($conn));  // Error handling
        }

        // Loop through the results and display each order
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['order_id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['total_amount']}</td>
                <td>{$row['status']}</td>
                <td>{$row['order_date']}</td>
            </tr>";
        }
        ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>
