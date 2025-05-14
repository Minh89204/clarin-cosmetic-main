<?php
session_start();

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $product = [
        'id' => $_POST['id'],
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'image' => $_POST['image'],
        'quantity' => 1
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $product['id']) {
            $item['quantity']++;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = $product;
    }

    header("Location: index.php");
    exit();
}

// Xóa sản phẩm
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: index.php");
    exit();
}

// Cập nhật giỏ hàng
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $quantity) {
        if ($quantity == 0) {
            unset($_SESSION['cart'][$id]);
        } else {
            $_SESSION['cart'][$id]['quantity'] = $quantity;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header("Location: index.php");
    exit();
}

// Tính tổng tiền
$total_price = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
}
?>

<!-- CSS ngay tại đây -->
<style>
.cart-container {
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
}
.cart-container h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
}
.cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ddd;
}
.cart-item-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    margin-right: 20px;
    border-radius: 8px;
}
.cart-item-info {
    flex: 1;
}
.cart-item-name {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}
.cart-item-price {
    color: #e74c3c;
    font-weight: bold;
    margin-bottom: 5px;
}
.cart-item-quantity {
    width: 60px;
    padding: 5px;
    margin-left: 5px;
}
.remove-item {
    display: inline-block;
    margin-top: 10px;
    color: #e74c3c;
    text-decoration: none;
    font-size: 14px;
}
.remove-item:hover {
    text-decoration: underline;
}
.cart-summary {
    text-align: right;
    margin-top: 20px;
    font-size: 18px;
}
.update-cart-btn {
    display: block;
    margin: 20px auto 0;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.update-cart-btn:hover {
    background-color: #2980b9;
}
.cart-actions {
    text-align: center;
    margin-top: 30px;
}
.checkout-btn {
    display: inline-block;
    padding: 12px 24px;
    background-color: #2ecc71;
    color: white;
    text-decoration: none;
    font-size: 16px;
    border-radius: 5px;
}
.checkout-btn:hover {
    background-color: #27ae60;
}
</style>

<!-- Nội dung Popup Giỏ hàng -->
<div class="cart-container">
    <h1>Giỏ hàng của bạn</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>
        <form method="POST" action="cart.php">
    <?php foreach ($_SESSION['cart'] as $index => $item): ?>
        <div class="cart-item">
            <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="cart-item-img">
            <div class="cart-item-info">
                <p class="cart-item-name"><?= $item['name'] ?></p>
                <p class="cart-item-price"><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</p>
                <label for="quantity_<?= $index ?>">Số lượng: </label>
                <input type="number" id="quantity_<?= $index ?>" name="quantity[<?= $index ?>]" value="<?= $item['quantity'] ?>" min="1" class="cart-item-quantity">
                
                <!-- Nút Xóa có confirm -->
                <a href="cart.php?remove=<?= $index ?>" 
                   class="remove-item" 
                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">
                   Xóa
                </a>
            </div>
        </div>
    <?php endforeach; ?>

            <div class="cart-summary">
                <p><strong>Tổng cộng: <?= number_format($total_price, 0, ',', '.') ?> VNĐ</strong></p>
                <button type="submit" name="update_cart" class="update-cart-btn">Cập nhật giỏ hàng</button>
            </div>
        </form>

        <div class="cart-actions">
            <a href="checkout.php" class="checkout-btn">Thanh toán</a>
        </div>
    <?php endif; ?>
</div>
