<?php
ob_start();
include '../partials/head.php';
?>

<div class="form">

	<?php
	if (filter_has_var(INPUT_GET, 'supplier_id')) {

		$clean_id = filter_var($_GET['supplier_id'], FILTER_SANITIZE_NUMBER_INT);
		$supplier_id = filter_var($clean_id, FILTER_VALIDATE_INT);

		$sql = "SELECT * from suppliers where supplier_id = $supplier_id";
		$res = mysqli_query($conn, $sql);

		//Check whether the query is executed or not.
		if ($res) {
			$count = mysqli_num_rows($res);
			if ($count === 1) {
				$row = mysqli_fetch_assoc($res);

				$supplier_lastname = htmlspecialchars($row['supplier_lastname']);
				$supplier_firstname = htmlspecialchars($row['supplier_firstname']);
				$sanitize_contact = filter_var($row['contact_number'], FILTER_SANITIZE_NUMBER_INT);
				$contact_number = filter_var($sanitize_contact, FILTER_VALIDATE_INT);
				$sanitize_email = filter_var($row['email'], FILTER_SANITIZE_EMAIL);
				$email = filter_var($sanitize_email, FILTER_VALIDATE_EMAIL);
				$address = htmlspecialchars($row['address']);
				$country = htmlspecialchars($row['country']);
				$postal_code = htmlspecialchars($row['postal_code']);
				$active = htmlspecialchars($row['active']);
			} else {
				$_SESSION['no_supplier_data_found'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Supplier Profile Data Not Found
						</div>
					</div>
				";
				header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
			}
		}
	} else {
		$_SESSION['no_supplier_id_found'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Supplier Id Not Found
				</div>
			</div>
		";
		header('location:' . SITEURL . 'admin/supplier_manage.php');
	}

	?>

	<div class="row">
		<form action="" method="POST" enctype="multipart/form-data" class="crud">
			<h2>Update Supplier Profile</h2>
			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="lastname" id="lastname" pattern="[A-Za-z ]+" value="<?php echo $supplier_lastname; ?>" required autofocus>
					<label for="lastname">Lastname</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="firstname" id="firstname" pattern="[A-Za-z ]+" value="<?php echo $supplier_firstname; ?>" required>
					<label for="firstname">Firstname</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="tel" name="contactnumber" pattern="09[0-9+]{9}" title="09XXXXXXXXX" maxLength="11" value="<?php echo $contact_number; ?>" required>
					<label for="contactnumber">Phone Number</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="email" name="email" id="email" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9 -]+\.[a-z]{2,}" value="<?php echo $email; ?>" required>
					<label for="email">Email</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="address" id="address" title="Brgy., Municipality/City, Provice" pattern="[A-Za-z0-9,.-+_*]+\, [A-Za-z0-9,.-+_]+\, [A-Za-z0-9,.-+_]+" value="<?php echo $address; ?>" required>
					<label for="address">Address</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="postalcode" id="postalcode" pattern="[0-9]+" value="<?php echo $postal_code; ?>" required>
					<label for="postalcode">Postal Code</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="country" id="country" pattern="[A-Za-z- ]+" value="<?php echo $country; ?>" required>
					<label for="country">Country</label>
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
				<input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">
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
	$sanitize_id = filter_var($_POST['supplier_id'], FILTER_SANITIZE_NUMBER_INT);
	$supplier_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);

	$supplier_lastname = htmlspecialchars(ucwords($_POST['lastname']));
	$supplier_firstname = htmlspecialchars(ucwords($_POST['firstname']));

	$contact_number = htmlspecialchars($_POST['contactnumber']);

	$sanitize_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$email = filter_var($sanitize_email, FILTER_VALIDATE_EMAIL);

	$address = htmlspecialchars(ucwords($_POST['address']));
	$country = htmlspecialchars(ucwords($_POST['country']));
	$postal_code = htmlspecialchars($_POST['postalcode']);
	$active = htmlspecialchars($_POST['active']);

	$sql = "UPDATE suppliers SET
		supplier_lastname = '$supplier_lastname',
		supplier_firstname = '$supplier_firstname',
		contact_number = '$contact_number',
		email = '$email',
		address = '$address',
		country = '$country',
		postal_code = '$postal_code',
		active = '$active'
		WHERE supplier_id = $supplier_id
	";

	$res = mysqli_query($conn, $sql);

	if ($res) {
		$_SESSION['update'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Supplier Profile Updated Successfully
				</div>
			</div>
		";

		header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
	} else {
		$_SESSION['update'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Failed to Update Supplier Profile
				</div>
			</div>
		";
		header('location:' . SITEURL . 'admin/supplier_manage/supplier_manage.php');
	}
}
ob_end_flush();
?>