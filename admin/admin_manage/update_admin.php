<?php include '../partials/head.php'; ?>

<div class="form">

	<?php
	if (filter_has_var(INPUT_GET, 'admin_id')) {

		$clean_id = filter_var($_GET['admin_id'], FILTER_SANITIZE_NUMBER_INT);
		$admin_id = filter_var($clean_id, FILTER_VALIDATE_INT);

		$adminQuery = "SELECT * from users where user_id = :user_id";
		$adminStatement = $pdo->prepare($adminQuery);
		$adminStatement->bindParam(':user_id', $admin_id, PDO::PARAM_INT);

		//Check whether the query is executed or not.
		if ($adminStatement->execute()) {
			$adminCount = $adminStatement->rowCount();

			if ($adminCount === 1) {
				$admin = $adminStatement->fetch(PDO::FETCH_ASSOC);
				$lastname = $admin['user_lastname'];
				$firstname = $admin['user_firstname'];
				$username = $admin['user_username'];
			} else {
				$_SESSION['no_admin_data_found'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Admin Profile Data Not Found
						</div>
					</div>
				";

				header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
			}
		}
	}


	?>
	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="crud">
			<h2>Update Admin</h2>
			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" pattern="[A-Za-z ]+" required autofocus>
					<label for="lastname">Lastname</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" pattern="[A-Za-z ]+" required>
					<label for="firstname">Firstname</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="username" id="username" title="Must be at least 5 characters" value="<?php echo $username; ?>" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]+{5,}" required>
					<label for="username">Username</label>
				</div>
			</div>

			<div>
				<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<button type="submit" name="submit" class="btn">Update Admin</button>
			</div>
		</form>
	</div>
	<div class="form-background">
		<img src="../../images/admin-bg/admin-background.svg" alt="admin-background" />
	</div>
</div>

<?php
if (filter_has_var(INPUT_POST, 'submit')) {
	$clean_id = filter_var($_POST['admin_id'], FILTER_SANITIZE_NUMBER_INT);
	$admin_id = filter_var($clean_id, FILTER_VALIDATE_INT);

	$lastname = htmlspecialchars(ucwords($_POST['lastname']));
	$firstname = htmlspecialchars(ucwords($_POST['firstname']));
	$username = htmlspecialchars($_POST['username']);

	$updateadminQuery = "UPDATE users SET
		user_lastname = :lastname,
		user_firstname = :firstname,
		user_username = :username
		WHERE user_id = :admin_id
	";

	$updateadminStatement = $pdo->prepare($updateadminQuery);
	$updateadminStatement->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
	$updateadminStatement->bindParam(':lastname', $lastname);
	$updateadminStatement->bindParam(':firstname', $firstname);
	$updateadminStatement->bindParam(':username', $username);

	if ($updateadminStatement->execute()) {
		$_SESSION['update'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Admin Profile Updated Successfully
				</div>
			</div>
		";

		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	} else {
		$_SESSION['update'] = "
			<div class='alert alert--danger' id='alert'>
                <div class='alert__message'>	
                    Failed to Update Admin Profile
                </div>
			</div>
		";

		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	}
}

?>