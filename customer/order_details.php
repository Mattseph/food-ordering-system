<?php
ob_start();
include 'customer-partials/header.php';
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

    $foodQuery = "SELECT * FROM food_list WHERE food_id = :food_id";
    $foodStatement = $pdo->prepare($foodQuery);
    $foodStatement->bindParam(':food_id', $food_id);

    if ($foodStatement->execute()) {
        $foodCount = $foodStatement->rowCount();

        if ($foodCount == 1) {
            $food = $foodStatement->fetch(PDO::FETCH_ASSOC);

            $sanitize_id  = sanitize_int($food['food_id']);
            $food_id = validate_int($sanitize_id);
            $food_name = validate_string($food['food_name']);
            $food_price = $food['food_price'];
            $image_name = validate_string($food['image_name']);
        }
    }
} else {
    echo "<script>alert('NO ID FOUND')</script>";
}

$active = "Yes";
$riderQuery = "SELECT * FROM delivery_rider WHERE active = :active";
$riderStatement = $pdo->prepare($riderQuery);
$riderStatement->bindParam(':active', $active);

if ($riderStatement->execute()) {
    $riderCount = $riderStatement->rowCount();

    if ($riderCount > 0) {
        $rider = $riderStatement->fetch(PDO::FETCH_ASSOC);

        $rider_id = $rider['rider_id'];
        $rider_lastname = $rider['rider_lastname'];
        $rider_firstname = $rider['rider_firstname'];
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
            </section>
        </form>
    </section>
</section>
<!-- Food Order Section Ends Here -->

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

        $insertorderQuery = "INSERT INTO order_details
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
                            :order_id,
                            :customer_lastname, 
                            :customer_firstname,
                            :contact_number,
                            :address,
                            :postal_code,
                            :rider_id,  
                            :food_id, 
                            :quantity, 
                            :total, 
                            :mode_of_payment,
                            :order_date,
                            :expected_delivery,
                            :status
                        )";

        $insertorderStatement = $pdo->prepare($insertorderQuery);
        $insertorderStatement->bindParam(':order_id', $order_id);
        $insertorderStatement->bindParam(':customer_lastname', $customer_lastname);
        $insertorderStatement->bindParam(':customer_firstname', $customer_firstname);
        $insertorderStatement->bindParam(':contact_number', $contact_number);
        $insertorderStatement->bindParam(':address', $address);
        $insertorderStatement->bindParam(':postal_code', $postal_code, PDO::PARAM_INT);
        $insertorderStatement->bindParam(':rider_id', $rider_id, PDO::PARAM_INT);
        $insertorderStatement->bindParam(':food_id', $food_id, PDO::PARAM_INT);
        $insertorderStatement->bindParam(':quatity', $quatity, PDO::PARAM_INT);
        $insertorderStatement->bindParam(':total', $total, PDO::PARAM_INT);
        $insertorderStatement->bindParam(':mode_of_payment', $mode_of_payment);
        $insertorderStatement->bindParam(':order_date', $order_date);
        $insertorderStatement->bindParam(':expected_delivery', $expected_delivery);
        $insertorderStatement->bindParam(':status', $status);

        if ($insertorderStatement->execute()) {
            $_SESSION['order'] = "
                <div class='alert alert--success' id='alert'>
                    <div class='alert__message'>
                        Food Ordered Successfully
                    </div>
                </div>
            ";

            $_SESSION['food_id'] = $food_id;

            header('location:' . SITEURL . 'customer/order_summary.php');
        } else {
            $_SESSION['order'] = "
                <div class='alert alert--danger' id='alert'>
                    <div class='alert__message'>	
                        Order Failed
                    </div>
                </div>
            ";
            header("location:" . SITEURL . "customer/order_details.php?food_id='$food_id'");
        }
    }
} else {
    $_SESSION['signin-required'] = "
        <div class='alert alert--danger' id='alert'>
            <div class='alert__message'>	
                Sign in Required
            </div>
        </div>
    ";
    header('location:' . SITEURL . 'customer/signin.php');
}
ob_end_flush();
?>

</body>

</html>