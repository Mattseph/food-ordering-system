<?php include '../partials/head.php'; ?>

<div class="form">

	<?php

	if (filter_has_var(INPUT_GET, 'admin_id')) {
		$sanitize_id = filter_var($_GET['admin_id'], FILTER_SANITIZE_NUMBER_INT);
		$admin_id = filter_var($sanitize_id, FILTER_VALIDATE_INT);
	}
	?>
	<div class="row">
		<form action="" method="POST" autocomplete="off" enctype="multipart/form-data" class="crud">
			<h2>Change Password</h2>

			<?php

			if (isset($_SESSION['change_pass_failed'])) {
				echo $_SESSION['change_pass_failed'];
				unset($_SESSION['change_pass_failed']);
			}

			if (isset($_SESSION['pass_not_match'])) {
				echo $_SESSION['pass_not_match'];
				unset($_SESSION['pass_not_match']);
			}

			if (isset($_SESSION['user_not_found'])) {
				echo $_SESSION['user_not_found'];
				unset($_SESSION['user_not_found']);
			}

			?>
			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="currentpassword" id="currentpassword" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required autofocus>
					<label for="currentpassword">Current Password</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="newpassword" id="newpassword" title="Must be at least 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
					<label for="newpassword">New Password</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="confirmpassword" id="confirmpassword" title="Must be atleast 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
					<label for="confirmpassword">Confirm Password</label>
				</div>
			</div>

			<div>
				<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
				<button type="submit" name="submit" class="btn">Update Password</button>
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

	$currentpassword = htmlspecialchars(md5($_POST['currentpassword']));
	$newpassword = htmlspecialchars(md5($_POST['newpassword']));
	$confirmpassword = htmlspecialchars(md5($_POST['confirmpassword']));

	$adminQuery = "SELECT * FROM users WHERE user_id = :admin_id AND user_password = :currentpassword";
	$adminStatement = $pdo->prepare($adminQuery);
	$adminStatement->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
	$adminStatement->bindParam(':currentpassword', $currentpassword);

	if ($adminStatement->execute()) {
		$adminCount = $adminStatement->rowCount();

		if ($adminCount === 1) {
			if ($newpassword == $confirmpassword) {

				$updatepasswordQuery = "UPDATE users SET 
						user_password = :newpassword
						where user_id = :admin_id
				";
				$updatepaswwordStatement = $pdo->prepare($updatepasswordQuery);
				$updatepaswwordStatement->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
				$updatepaswwordStatement->bindParam(':newpassword', $newpassword);

				if ($updatepaswwordStatement->execute()) {
					$_SESSION['change_pass_success'] = "
						<div class='alert alert--success' id='alert'>
							<div class='alert__message'>
								Password Successfully Changed
							</div>
						</div>
					";

					header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
				} else {
					$_SESSION['change_pass_failed'] = "
						<div class='alert alert--danger' id='alert'>
							<div class='alert__message'>	
								Failed To Change Password
							</div>
						</div>
					";

					header('location:' . SITEURL . "admin/admin_manage/update_password.php?admin_id='$admin_id'");
				}
			} else {
				$_SESSION['pass_not_match'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Password Did Not Match, Please Try Again
						</div>
					</div>
				";
				header('location:' . SITEURL . "admin/admin_manage/update_password.php?admin_id='$admin_id");
			}
		} else {
			$_SESSION['user_not_found'] = "
				<div class='alert alert--danger' id='alert'>
					<div class='alert__message'>	
						Invalid Current Password
					</div>
				</div>
			";
			header('location:' . SITEURL . "admin/admin_manage/update_password.php?admin_id='$admin_id'");
		}
	}
}
?>