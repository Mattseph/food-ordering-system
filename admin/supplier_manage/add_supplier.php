<?php
ob_start();
include '../partials/head.php';
?>
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
        <form action="" method="POST" enctype="multipart/form-data" class="crud">
            <h2>Add Supplier Profile</h2>
            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="lastname" id="lastname" pattern="[A-Za-z ]+" required autofocus>
                    <label for="lastname">Lastname</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="firstname" id="firstname" pattern="[A-Za-z ]+" required>
                    <label for="firstname">Firtname</label>
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
                    <input type="email" name="email" id="email" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9]+\.[A-Za-z]{2,}$" required>
                    <label for="email">Email</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="address" id="address" title="Brgy., Municipality/City, Provice" pattern="[A-Za-z0-9,.-+_*]+\, [A-Za-z0-9,.-+_]+\, [A-Za-z0-9,.-+_]+" required>
                    <label for="address">Address</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="postalcode" id="postalcode" pattern="[0-9]+" required>
                    <label for="postalcode">Postal Code</label>
                </div>
            </div>

            <div class="form-group">
                <div class="placeholder">
                    <input type="text" name="country" id="country" pattern="[A-Za-z- ]+" required>
                    <label for="country">Country</label>
                </div>
            </div>

            <div class="form-group">
                <div class="active">
                    <label for="active">Active:</label>
                    <div>
                        <label for="yes">Yes</label>
                        <input type="radio" id="yes" name="active" value="Yes">
                    </div>
                    <div>
                        <label for="no">No</label>
                        <input type="radio" id="no" name="active" value="No">
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
    $supplier_lastname = htmlspecialchars(ucwords($_POST['lastname']));
    $supplier_firstname = htmlspecialchars(ucwords($_POST['firstname']));
    $contact_number = htmlspecialchars($_POST['contactnumber']);
    $sanitize_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = filter_var($sanitize_email, FILTER_VALIDATE_EMAIL);
    $address = htmlspecialchars(ucwords($_POST['address']));
    $country = htmlspecialchars(ucwords($_POST['country']));
    $postal_code = htmlspecialchars($_POST['postalcode']);
    $active = htmlspecialchars($_POST['active']);


    $sql = "INSERT INTO suppliers
        (
			supplier_lastname,
            supplier_firstname,
            contact_number,
            email,
            address,
            country,
            postal_code,
            active
        )
        VALUES
        (
            '$supplier_lastname',
			'$supplier_firstname',
			'$contact_number',
			'$email',
			'$address',
			'$country',
			'$postal_code',
            '$active'
		)";

    $res = mysqli_query($conn, $sql);

    if ($res) {
        //To show display messege once data has been inserted
        $_SESSION['add'] = "<div id='message' class='success supplier-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Supplier Added Successfully</span></div>";
        //Redirecting page to manage admin
        header("location:" . SITEURL . 'admin/supplier_manage/supplier_manage.php');
    } else {
        //To show display messege once data has been inserted
        $_SESSION['add'] = "<div id='message' class='fail supplier-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Add Supplier</span></div>";
        //Redirecting page to add admin
        header("location:" . SITEURL . 'admin/supplier_manage/add_supplier.php');
    }
}
ob_end_flush();
?>