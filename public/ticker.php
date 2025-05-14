<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
$datetime = date("Y-m-d H:i:s");
$location = "Hà Nội, Việt Nam"; // Vị trí địa lý có thể thay đổi

echo "<div style='background-color: #333; color: white; padding: 5px; text-align: center;'>";
echo "Ngày giờ hiện tại: " . $datetime . " | Vị trí: " . $location;
echo "</div>";
?>

