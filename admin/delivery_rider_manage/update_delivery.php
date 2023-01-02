<?php include '../partials/head.php'; ?>

<div class="form">

    <?php
    //Checking and Getting the passed company_name
    if (filter_has_var(INPUT_GET, 'rider_id')) {
        $clean_rider_id = filter_var($_GET['rider_id'], FILTER_SANITIZE_NUMBER_INT);
        $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);
        //Create a query that select all from delivery company table where the passed company name is the same as the company name value in databse.
        $sql = "SELECT * FROM delivery_rider WHERE rider_id = '$rider_id'";
        //Execute the query above.
        $res = mysqli_query($conn, $sql);

        //Check whether the query is executed or not.
        if ($res) {
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $clean_rider_id = filter_var($row['rider_id'], FILTER_SANITIZE_NUMBER_INT);
                $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);

                $rider_lastname = htmlspecialchars($row['rider_lastname']);

                $rider_firstname = htmlspecialchars($row['rider_firstname']);

                $clean_contact = filter_var($row['contact_number'], FILTER_SANITIZE_NUMBER_INT);
                $contactnumber = filter_var($clean_contact, FILTER_VALIDATE_INT);

                $clean_email = filter_var($row['email'], FILTER_SANITIZE_EMAIL);
                $email = filter_var($clean_email, FILTER_SANITIZE_EMAIL);
                $active = htmlspecialchars($row['active']);
            } else {
                $_SESSION['no_riderid_found'] = "<div id='message' class='fail delivery-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Rider id not found</span></div>";

                header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
            }
        }
    } else {
        $_SESSION['no_riderid_found'] = "<div id='message' class='fail delivery-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Rider id not found</span></div>";

        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    }



    ?>
    <div class="row">
        <form action="" method="POST" enctype="multipart/form-data" class="crud">
            <h2>Update Rider Profile</h2>
            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="lastname" id="lastname" value="<?php echo $rider_lastname; ?>" pattern="[A-Za-z]+" required autofocus>
                    <label for="lastname">Last Name</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="firstname" id="firstname" value="<?php echo $rider_firstname; ?>" pattern="[A-Za-z]+" required>
                    <label for="firstname">Firstame</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="tel" name="contactnumber" id="contactnumber" pattern="09[0-9+]{9}" title="09XXXXXXXXX" maxLength="11" value="<?php echo $contactnumber; ?>" required>
                    <label for="contactnumber">Phone Number</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9 -]+\.[a-z]{2,}" required>
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="form-group">
                <div class="active">
                    <label for="active">Active: </label>
                    <div>
                        <label for="yes">Yes</label>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" id="yes" name="active" value="Yes">
                    </div>
                    <div>
                        <label for="no">No</label>
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" id="no" name="active" value="No">
                    </div>
                </div>
            </div>

            <div>
                <input type="hidden" name="rider_id" value="<?php echo $rider_id; ?>" />
                <button type="submit" name="submit" class="btn">Update</button>
            </div>
        </form>
    </div>
    <div class="form-background">
        <img src="../../images/admin-bg/admin-background.svg" alt="admin-background" />
    </div>
</div>

<?php
if (filter_has_var(INPUT_POST, 'submit')) {
    $rider_lastname = htmlspecialchars(ucwords($_POST['lastname']));
    $rider_firstname = htmlspecialchars(ucwords($_POST['firstname']));
    $contact_number = htmlspecialchars($_POST['contactnumber']);
    $clean_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_var($clean_email, FILTER_SANITIZE_EMAIL);
    $active = htmlspecialchars($_POST['active']);

    $sql2 = "UPDATE delivery_rider SET
		rider_lastname = '$rider_lastname',
		rider_firstname = '$rider_firstname',
		contact_number = '$contact_number',
		email = '$email',
        active = '$active'
		WHERE rider_id = $rider_id
	";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2) {
        $_SESSION['update'] = "<div id='message' class='success delivery-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Updated Successfully</span></div>";

        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    } else {
        $_SESSION['update'] = "<div id='message' class='fail delivery-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Update</span></div>";

        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    }
}

?>