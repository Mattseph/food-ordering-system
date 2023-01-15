<?php
include '../customer-partials/header.php';

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = (int) $_GET['product_id'];
    $quantity = (int) $_GET['quantity'];

    // Check if the product exists in the database
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 0) {
        // The product does not exist, show an error message
        echo "Sorry, the product does not exist";
    } else {
        // The product exists, add it to the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // The product is already in the cart, increase the quantity
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            // The product is not in the cart, add it
            $_SESSION['cart'][$product_id] = $quantity;
      }
    }
}
$food_id = $_POST['food_id'];
$sql = "SELECT * FROM food_list WHERE food_id = '$food_id'";

$res = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($res);
