<?php
ob_start();
include '../partials/head.php';
?>
<div class="form">
    <?php
    if (filter_has_var(INPUT_GET, 'order_id')) {
        $order_id = htmlspecialchars($_GET['order_id']);
        $sql2 = "SELECT * FROM order_details WHERE order_id = '$order_id'";

        $res2 = mysqli_query($conn, $sql2);

        if ($res2) {
            $count2 = mysqli_num_rows($res2);

            if ($count2 === 1) {
                $row2 = mysqli_fetch_assoc($res2);

                $order_id = $row2['order_id'];
                $customer_lastname = $row2['customer_lastname'];
                $customer_firstname = $row2['customer_firstname'];
                $delivery_address = $row2['delivery_address'];
                $food_id = $row2['food_id'];
                $quantity = $row2['quantity'];
                $total = $row2['total'];
                $mode_of_payment = $row2['mode_of_payment'];
                $status = $row2['status'];
            }
        }
    } else {
        $_SESSION['no_order_id_found'] = "
            <div class='alert alert--danger' id='alert'>
                <div class='alert__message'>	
                    Order Id Not Found
                </div>
            </div>
        ";

        header('location:' . SITEURL . 'admin/order_manage/order_manage.php');
    }
    ?>
    <div class="form-background">
        <img src="../../images/admin-bg/food-background.svg" alt="food-background" />
    </div>

    <div class="row">
        <form action="" method="POST" enctype="multipart/form-data" class="crud">
            <h2>Update Order</h2>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="lastname" id="lastname" placeholder="Lastname" value="<?php echo $customer_lastname; ?>" required readonly>
                    <label for="lastname">Lastname</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="firstname" id="firstname" placeholder="Firstame" value="<?php echo $customer_firstname; ?>" required readonly>
                    <label for="firstname">Firstname</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="address" id="address" value="<?php echo $delivery_address; ?>" required readonly>
                    <label for="address">Delivery Address</label>
                </div>
            </div>



            <div class="form-group">
                <div class="placeholder">
                    <input type="number" name="food_id" id="foodid" value="<?php echo $food_id; ?>" required readonly>
                    <label for="foodid">Food ID</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>" required readonly>
                    <label for="quantity">Quantity</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="number" name="total" id="total" value="<?php echo $total; ?>" required readonly>
                    <label for="total">Total</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="payment" id="modeofpayment" value="<?php echo $mode_of_payment; ?>" required readonly>
                    <label for="modeofpayment">Mode of Payment</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <select id="status" name="status" autofocus required>
                        <option <?php if ($status === "Ordered") {
                                    echo "Selected";
                                } ?> value="Ordered">Ordered</option>
                        <option <?php if ($status === "On Delivery") {
                                    echo "Selected";
                                } ?> value="On Delivery">On Delivery</option>
                        <option <?php if ($status === "Delivered") {
                                    echo "Selected";
                                } ?> value="Delivered">Delivered</option>
                        <option <?php if ($status === "Cancelled") {
                                    echo "Selected";
                                } ?> value="Cancelled">Cancelled</option>
                    </select>
                    <label for="status">Status</label>
                </div>
            </div>


            <div>
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <button type="submit" name="submit" class="btn"> Update Order </button>
            </div>
        </form>

        <?php
        if (filter_has_var(INPUT_POST, 'submit')) {
            $order_id = htmlspecialchars($_POST['order_id']);

            $lastname = htmlspecialchars(ucwords($_POST['lastname']));
            $firstname = htmlspecialchars(ucwords($_POST['firstname']));
            $address = htmlspecialchars(ucwords($_POST['address']));
            $status = htmlspecialchars(ucwords($_POST['status']));

            $clean_food_id = filter_var($_POST['food_id'], FILTER_SANITIZE_NUMBER_INT);
            $food_id = filter_var($clean_food_id, FILTER_VALIDATE_INT);

            $quantity = htmlspecialchars($_POST['quantity']);

            $total = htmlspecialchars($_POST['total']);

            $sql3 = "UPDATE order_details SET
				    customer_lastname = '$lastname',
					customer_firstname = '$firstname',
					delivery_address = '$address',
					food_id = $food_id,
					quantity = $quantity,
					total = $total,
                    status = '$status'
					WHERE order_id = '$order_id'
				";

            $res3 = mysqli_query($conn, $sql3);

            if ($res3) {
                $_SESSION['update'] = "
                    <div class='alert alert--success' id='alert'>
                        <div class='alert__message'>
                            Order Status Updated Successfully
                        </div>
                    </div>
                ";

                header('location:' . SITEURL . 'admin/order_manage/order_manage.php');
            } else {
                $_SESSION['update'] = "
                    <div class='alert alert--danger' id='alert'>
                        <div class='alert__message'>	
                            Failed to Update Order Status
                        </div>
                    </div>
                ";

                header('location:' . SITEURL . 'admin/order_manage/order_manage.php');
            }
        }
        ob_end_flush();
        ?>
    </div>
</div>