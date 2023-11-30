<?php include '../partials/head.php'; ?>

<div class="form">

    <?php
    //Checking and Getting the passed company_name
    if (filter_has_var(INPUT_GET, 'rider_id')) {
        $clean_rider_id = filter_var($_GET['rider_id'], FILTER_SANITIZE_NUMBER_INT);
        $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);
        //Create a query that select all from delivery company table where the passed company name is the same as the company name value in databse.
        $riderQuery = "SELECT * FROM delivery_rider WHERE rider_id = :rider_id";
        $riderStatement = $pdo->prepare($riderQuery);
        $riderStatement->bindParam(':rider_id', $rider_id, PDO::PARAM_INT);

        //Execute the query above and check whether the query is executed or not.
        if ($riderStatement->execute()) {
            $riderCount = $riderStatement->rowCount();

            if ($riderCount === 1) {
                $rider = $riderStatement->fetch(PDO::FETCH_ASSOC);

                $clean_rider_id = filter_var($rider['rider_id'], FILTER_SANITIZE_NUMBER_INT);
                $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);

                $rider_lastname = htmlspecialchars($rider['rider_lastname']);

                $rider_firstname = htmlspecialchars($rider['rider_firstname']);

                $contactnumber = htmlspecialchars($rider['contact_number']);


                $clean_email = filter_var($rider['email'], FILTER_SANITIZE_EMAIL);
                $email = filter_var($clean_email, FILTER_SANITIZE_EMAIL);
                $active = htmlspecialchars($rider['active']);
            } else {
                $_SESSION['no_rider_data_found'] = "
                    <div class='alert alert--danger' id='alert'>
                        <div class='alert__message'>	
                            Delivery Rider Profile Data Not Found
                        </div>
                    </div>
                ";

                header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
            }
        }
    }
    ?>
    <div class="row">
        <form action="" method="POST" enctype="multipart/form-data" class="crud">
            <h2>Update Rider Profile</h2>
            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="lastname" id="lastname" value="<?php echo $rider_lastname; ?>" pattern="[A-Za-z ]+" required autofocus>
                    <label for="lastname">Last Name</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="firstname" id="firstname" value="<?php echo $rider_firstname; ?>" pattern="[A-Za-z ]+" required>
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
    $clean_id = filter_var($_POST['rider_id'], FILTER_SANITIZE_NUMBER_INT);
    $rider_id = filter_var($clean_id, FILTER_VALIDATE_INT);
    $rider_lastname = htmlspecialchars(ucwords($_POST['lastname']));
    $rider_firstname = htmlspecialchars(ucwords($_POST['firstname']));
    $contact_number = htmlspecialchars($_POST['contactnumber']);
    $clean_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_var($clean_email, FILTER_SANITIZE_EMAIL);
    $active = htmlspecialchars($_POST['active']);

    $updateriderQuery = "UPDATE delivery_rider SET
		rider_lastname = :rider_lastname,
		rider_firstname = :rider_firstname,
		contact_number = :contact_number,
		email = :email,
        active = :active
		WHERE rider_id = :rider_id
	";

    $updateriderStatement = $pdo->prepare($updateriderQuery);
    $updateriderStatement->bindParam(':rider_id', $rider_id);
    $updateriderStatement->bindParam(':rider_lastname', $rider_lastname);
    $updateriderStatement->bindParam(':rider_firstname', $rider_firstname);
    $updateriderStatement->bindParam(':contact_number', $contact_number, PDO::PARAM_INT);
    $updateriderStatement->bindParam(':email', $email);
    $updateriderStatement->bindParam(':active', $active);

    if ($updateriderStatement->execute()) {
        $_SESSION['update'] = "
            <div class='alert alert--success' id='alert'>
                <div class='alert__message'>
                    Delivery Rider Profile Updated Successfully
                </div>
            </div>
        ";
        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    } else {
        $_SESSION['update'] = "
        <div class='alert alert--danger' id='alert'>
            <div class='alert__message'>	
                Failed to Update Delivery Rider Profile
            </div>
        </div>
    ";

        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    }
}

?>