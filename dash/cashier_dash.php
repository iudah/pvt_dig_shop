<?php include_once('dash.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product and Cart</title>
    <style>
        .product {
            display: flex;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        .product img {
            max-width: 100px;
            margin-right: 20px;
        }
        .cart {
            border: 1px solid #ddd;
            padding: 20px;
            width: 300px;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .cart-total {
            font-weight: bold;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>

<!-- Product Section -->
<div class="product">
    <img src="product-thumb.jpg" alt="Product Thumbnail"> <!-- Product Thumbnail -->
    <div>
        <h3>Product Name</h3> <!-- Product Name -->
        <p>ID: 12345</p> <!-- Product ID -->
        <p>Description: This is a brief description of the product.</p> <!-- Product Description -->
        <p>Price: $99.99</p> <!-- Product Price -->
        <p>Available Quantity: 20</p> <!-- Quantity Available -->
    </div>
</div>

<!-- Cart Section -->
<aside class="cart">
    <h3>Your Cart</h3>

    <div class="cart-item">
        <span>Product Name</span> <!-- Item Name -->
        <span>$99.99</span> <!-- Item Price -->
        <span>1</span> <!-- Quantity -->
        <span>$99.99</span> <!-- Net Price -->
    </div>

    <div class="cart-item">
        <span>Another Product</span> <!-- Item Name -->
        <span>$49.99</span> <!-- Item Price -->
        <span>2</span> <!-- Quantity -->
        <span>$99.98</span> <!-- Net Price -->
    </div>

    <div class="cart-total">
        <span>Total</span> <!-- Total Label -->
        <span>$199.97</span> <!-- Total Price -->
    </div>

    <button onclick="window.location.href='checkout.html';">Checkout</button> <!-- Checkout Button -->
</aside>

</body>
</html>
