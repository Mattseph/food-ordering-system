<?php include '../partials/head.php'; ?>

<div class="form">

	<?php
	if (filter_has_var(INPUT_GET, 'admin_id')) {

		$clean_id = filter_var($_GET['admin_id'], FILTER_SANITIZE_NUMBER_INT);
		$admin_id = filter_var($clean_id, FILTER_VALIDATE_INT);
		$sql = "SELECT * from admin_list where admin_id = '$admin_id'";
		$res = mysqli_query($conn, $sql);

		//Check whether the query is executed or not.
		if ($res) {
			$count = mysqli_num_rows($res);

			if ($count === 1) {
				$row = mysqli_fetch_assoc($res);
				$lastname = $row['lastname'];
				$firstname = $row['firstname'];
				$username = $row['username'];
			} else {
				$_SESSION['no_adminid_found'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Admin id not Found</span></div>";

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
					<input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>" pattern="[A-Za-z]+" required autofocus>
					<label for="lastname">Lastname</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>" pattern="[A-Za-z]+" required>
					<label for="firstname">Firstname</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="username" id="username" title="Must be at least 5 characters" value="<?php echo $username; ?>" pattern="[A-Za-z0-9 -@._]+{5,}" required>
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

	$sql = "UPDATE admin_list SET
		lastname = '$lastname',
		firstname = '$firstname',
		username = '$username'
		WHERE admin_id = '$admin_id'
	";

	$res = mysqli_query($conn, $sql);

	if ($res) {
		$_SESSION['update'] = "<div id='message' class='success admin-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Admin Updated Successfully</span></div>";

		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	} else {
		$_SESSION['update'] = "<div id='message' class='fail admin-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Update Admin</span></div>";

		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	}
}

?>