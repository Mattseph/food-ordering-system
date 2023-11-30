<?php include '../configuration.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <title>Order Summary</title>
    <link rel="icon" type="image/png" href="../images/logo/logo.png">
    <script src="../js/timer.js" type="text/javascript"></script>
</head>

<?php

$ordersummaryQuery = "SELECT * FROM order_details ORDER BY order_date DESC LIMIT 1";
$ordersummaryStatement = $pdo->query($ordersummaryQuery);

$ordersummaryCount = $ordersummaryStatement->rowCount();

if ($ordersummaryCount === 1) {
    $orders = $ordersummaryStatement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as $order) {

        $order_id = $order['order_id'];
        $customer_lastname = $order['customer_lastname'];
        $customer_firstname = $order['customer_firstname'];
        $customer_number = $order['contact_number'];
        $delivery_address = $order['delivery_address'];
        $mode_of_payment = $order['mode_of_payment'];
        $postalcode = $order['postalcode'];
        $order_date = $order['order_date'];
        $expected_delivery = $order['expected_delivery'];
        $quantity = $order['quantity'];
        $total = $order['total'];
    }
}


?>

<body>
    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>
    <div class="food-summary-container">
        <div class="food-summary-wrapper">
            <div class="customer-summary">
                <h1 style="text-align:center">Order Summary</h1>
                <h1>Puchased By</h1>
                <div><span class="title">Order ID: </span><span class="data"><?php echo $order_id; ?></span></div>
                <div><span class="title">Buyer Name: </span><span class="data"><?php echo ucwords($customer_lastname . ', ' . $customer_firstname, ', ') ?></span></div>
                <div><span class="title">Phone Number: </span><span class="data"><?php echo $customer_number; ?> </span></div>
                <div><span class="title">Delivery Address: </span><span class="data"><?php echo $delivery_address; ?></span></div>
                <div><span class="title">Mode of Payment: </span><span class="data"><?php echo $mode_of_payment; ?></span></div>
                <div><span class="title">Order Date and Time: </span><span class="data"><?php echo $order_date; ?></span></div>

                <div><span class="title">Expected Delivery: </span><span class="data"><?php echo $expected_delivery; ?></span></div>

            </div>
            <div class="food-summary">
                <?php
                $food_id = $_SESSION['food_id'];

                $foodQuery = "SELECT * FROM food_list WHERE food_id = '$food_id'";
                $foodStatement = $pdo->prepare($foodQuery);
                $foodStatement->bindParam(':food_id', $food_id);
                $foodStatement->execute();

                $foodCount = $foodStatement->rowCount();

                if ($foodCount === 1) {
                    $food = $foodStatement->fetch(PDO::FETCH_ASSOC);

                    $food_name = $food['food_name'];
                    $food_price = $food['food_price'];
                }
                ?>
                <h1>Ordered Food Details</h1>
                <table>
                    <tr>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>

                    <tr>
                        <td><?php echo $food_name; ?></td>
                        <td>$<?php echo $food_price ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td>$<?php echo $total; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" class="total"><span>Order Total: </span>$<?php echo $total; ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</body>

</html>