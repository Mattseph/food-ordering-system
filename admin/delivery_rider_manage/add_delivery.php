<?php include '../partials/head.php'; ?>

<div class="form">

    <?php
    if (isset($_SESSION['add'])) //Checking whether the session is set or not
    {    //DIsplaying session message
        echo $_SESSION['add'];
        //Removing session message
        unset($_SESSION['add']);
    }
    ?>
    <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="crud">
            <h2>Add Delivery Rider</h2>
            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="lastname" id="lastname" pattern="[A-Za-z ]+" required autofocus>
                    <label for="lastname">Lastname</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="firstname" id="firstname" pattern="[A-Za-z ]+" required>
                    <label for="firstname">Firstname</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="tel" name="contactnumber" id="contactnumber" pattern="09[0-9+]{9}" title="09XXXXXXXXX" maxLength="11" required>
                    <label for="contactnumber">Phone Number</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="email" id="email" name="email" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9 -]+\.[a-z]{2,}" required>
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="form-group">
                <div class="active">
                    <label for="active">Active: </label>
                    <div>
                        <label for="yes">Yes</label>
                        <input type="radio" id="yes" name="active" value="Yes" required>
                    </div>
                    <div>
                        <label for="no">No</label>
                        <input type="radio" id="no" name="active" value="No" required>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" name="submit" class="btn">Add</button>
            </div>
        </form>
    </div>

    <div class="form-background">
        <img src="../../images/admin-bg/admin-background.svg" alt="admin-background" />
    </div>
</div>


<?php
if (filter_has_var(INPUT_POST, 'submit')) {
    $rider_lastname = htmlspecialchars(ucwords($_POST["lastname"]));
    $rider_firstname = htmlspecialchars(ucwords($_POST["firstname"]));
    $contactnumber = htmlspecialchars($_POST['contactnumber']);
    $clean_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_var($clean_email, FILTER_SANITIZE_EMAIL);

    if (filter_has_var(INPUT_POST, 'active')) {
        $active = htmlspecialchars($_POST['active']);
    } else {
        $active = "No";
    }


    $sql = "INSERT INTO delivery_rider
        (
			rider_lastname,
            rider_firstname,
            contact_number,
            email,
            active
        )
        VALUES
        (
            '$rider_lastname',
			'$rider_firstname',
			'$contactnumber',
			'$email',
            '$active'
	    )";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        //To show display messege once data has been inserted
        $_SESSION['add'] = "<div id='message' class='success delivery-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Delivery Rider Added Successfully</span></div>";

        //Redirecting page to delivery company manage.
        header("location:" . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    } else {
        //To show display messege once data has been inserted
        $_SESSION['add'] = "<div id='message' class='fail delivery-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Add Delivery Rider</span></div>";

        //Redirecting page to delivery company manage.
        header("location:" . SITEURL .    'admin/delivery_rider_manage/delivery_manage.php');
    }
}

?>