<?php
ob_start();
include 'front-partials/header.php';
?>
<?php
$_SESSION['ID'] = bin2hex(random_bytes(10));

function sanitize_int($int)
{
    return filter_var($int, FILTER_SANITIZE_NUMBER_INT);
}

function validate_int($int)
{
    return filter_var($int, FILTER_VALIDATE_INT);
}

function validate_string($string)
{
    return htmlspecialchars($string);
}


if (filter_has_var(INPUT_GET, 'food_id')) {
    $clean_id = sanitize_int($_GET['food_id']);
    $food_id = validate_int($clean_id);

    $sql = "SELECT * FROM food_list WHERE food_id = '$food_id'";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            $row = mysqli_fetch_assoc($res);

            $sanitize_id  = sanitize_int($row['food_id']);
            $food_id = validate_int($sanitize_id);
            $food_name = validate_string($row['food_name']);
            $food_price = $row['food_price'];
            $image_name = validate_string($row['image_name']);
        }
    }
} else {
    echo "<script>alert('NO ID FOUND')</script>";
}


$sql3 = "SELECT * FROM delivery_rider WHERE active = 'YES'";
$res3 = mysqli_query($conn, $sql3);

if ($res3) {
    $count3 = mysqli_num_rows($res3);

    if ($count3 > 0) {
        $row = mysqli_fetch_assoc($res3);

        $rider_id = $row['rider_id'];
        $rider_lastname = $row['rider_lastname'];
        $rider_firstname = $row['rider_firstname'];
    }
}

?>

<section class="food-order-wrapper">
    <?php
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
    ?>
    <section class="food-order-container">
        <h2 style="margin-bottom: 60px">Fill this form to confirm your order.</h2>
        <form action="" method="POST" class="food-order-summary" enctype="multipart/form-data">
            <section class="food-order-head">
                <div class="food-order-img">
                    <?php
                    if ($image_name == "") {
                        echo "<div>No Image Found</div>";
                    } else {
                    ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>" class="img-responsive">
                    <?php
                    }
                    ?>
                </div>

                <div class="food-order-label">
                    <p class="order-title">Food Name: <?php echo $food_name; ?></p>
                    <p class="order-title">Price: $<?php echo $food_price; ?></p>
                    <div class="order-label">
                        <div class="placeholder">
                            <input type="number" id="quantity" name="quantity" class="input-responsive" value="1">
                            <label for="quantity">Quantity</label>
                        </div>
                    </div>
                </div>

            </section>

            <section class="food-order-form">
                <h3>Delivery Details</h3>
                <div class="order-label">
                    <div class="placeholder">
                        <input type="text" name="lastname" id="lastname" class="input-responsive" pattern="[A-Za-z ]+" required autofocus>
                        <label for="lastname">Lastname</label>
                    </div>

                </div>

                <div class="order-label">
                    <div class="placeholder">
                        <input type="text" name="firstname" id="firstame" class="input-responsive" pattern="[A-Za-z ]+" required>
                        <label for="firstname">Firstname</label>
                    </div>
                </div>

                <div class="order-label">
                    <div class="placeholder">
                        <input type="tel" name="contactnumber" title="Must Be 11-Digit" id="contactnumber" class="input-responsive" pattern="09[0-9+]{9}" title="09XXXXXXXXX" maxLength="11" required>
                        <label for="contactnumber">Phone Number</label>
                    </div>
                </div>

                <div class="order-label">
                    <div class="placeholder">
                        <input type="text" name="address" id="address" title="Brgy., Municipality/City, Provice" pattern="[A-Za-z0-9, .-+_*]+\, [A-Za-z0-9, .-+_]+\, [A-Za-z0-9, .-+_]+\, [A-Za-z0-9,.-+_]+" class="input-responsive" required>
                        <label for="address">Delivery Address</label>
                    </div>
                </div>

                <div class="order-label">
                    <div class="placeholder">
                        <input type="text" name="postalcode" id="postalcode" pattern="[0-9-+]+" class="input-responsive" required>
                        <label for="postalcode">Postal Code</label>
                    </div>
                </div>
                <div class="order-label">
                    <div class="placeholder">
                        <input type="text" name="payment" id="modeofpayment" class="input-responsive" value="Cash on Delivery" style="font-weight: bold" required>
                        <label for="modeofpayment">Mode of Payment</label>
                    </div>
                </div>

                <div class="order-button">
                    <input type="hidden" name="foodprice" value="<?php echo $food_price ?>">
                    <input type="hidden" name="food_id" value="<?php echo $food_id ?>">
                    <input type="hidden" name="rider_id" value="<?php echo $rider_id ?>">
                    <input type="hidden" name="order_id" value="<?php echo $_SESSION['ID']; ?>">
                    <button type="submit" name="submit" value="Confirm Order" class="btn">Confirm Order</button>
                </div>

                <?php
                if (isset($_SESSION['user_id'])) {
                    if (filter_has_var(INPUT_POST, 'submit')) {
                        $order_id = validate_string($_POST['order_id']);
                        $customer_lastname = validate_string(ucwords($_POST['lastname']));
                        $customer_firstname = validate_string(ucwords($_POST['firstname']));

                        $contact_number = validate_string($_POST['contactnumber']);

                        $address = validate_string(ucwords($_POST['address']));

                        $sanitize_postal = sanitize_int($_POST['postalcode']);
                        $postal_code = validate_int($sanitize_postal);

                        $clean_rider_id = sanitize_int($_POST['rider_id']);
                        $rider_id = validate_int($clean_rider_id);

                        $sanitize_foodid = sanitize_int($_POST['food_id']);
                        $food_id = validate_int($sanitize_foodid);

                        $food_price = validate_string($_POST['foodprice']);
                        $quantity = validate_string($_POST['quantity']);

                        $total = validate_string($food_price * $quantity);

                        $mode_of_payment = validate_string('Cash on Delivery');

                        $order_date = date("Y-m-d h:i:s");

                        // Set the current time
                        $current_time = time();

                        // Set the expected time of delivery
                        $expected_time = $current_time + (60 * 30); // Add one hour to the current time

                        // Print the expected time of delivery
                        $expected_delivery = date("Y-m-d h:i:s", $expected_time);

                        $status = validate_string("Ordered");

                        $sql2 = "INSERT INTO order_details
                        (
                            order_id, 
                            customer_lastname,
                            customer_firstname,
                            contact_number,
                            delivery_address,
                            postalcode,
                            rider_id,
                            food_id,
                            quantity,
                            total,
                            mode_of_payment,
                            order_date,
                            expected_delivery,
                            status
                        )
                        VALUES 
                        (
                            '$order_id',
                            '$customer_lastname', 
                            '$customer_firstname',
                            '$contact_number',
                            '$address',
                            '$postal_code',
                            $rider_id,  
                            $food_id, 
                            $quantity, 
                            $total, 
                            '$mode_of_payment',
                            '$order_date',
                            '$expected_delivery',
                            '$status'
                        )";

                        $res2 = mysqli_query($conn, $sql2);

                        if ($res2) {
                            $_SESSION['order'] = "<div id='message' class='success order-message'><img src='../images/logo/successful.svg' alt='successful' class='successful'><span>Food Ordered Successfully</span></div>";

                            $_SESSION['food_id'] = $food_id;

                            header('location:' . SITEURL . 'frontend/order_summary.php');
                        } else {
                            $_SESSION['order'] = "<div id='message' class='fail order-message'><img src='../images/logo/warning.svg' alt='warning' class='warning'><span>Order Failed</span</div>";
                            header('location:' . SITEURL . 'frontend/order_details.php');
                        }
                    }
                } else {
                    header('location:' . SITEURL . 'frontend/signin.php');
                }
                ob_end_flush();
                ?>
            </section>
        </form>
    </section>
</section>
<!-- Food Order Section Ends Here -->


</body>

</html>