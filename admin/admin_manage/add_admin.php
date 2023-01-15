<?php include '../partials/head.php'; ?>

<div class="form">

	<?php
	if (isset($_SESSION['add'])) //Checking whether the session is set or not
	{	//DIsplaying session message
		echo $_SESSION['add'];
		//Removing session message
		unset($_SESSION['add']);
	}
	?>
	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off" enctype="multipart/form-data" class="crud">
			<h2>Add Admin</h2>
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
					<input type="text" name="username" id="username" title="Username must be at least 5 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{5,}" required>
					<label for="username">Username</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="password1" id="password" title="Password must be atleast 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
					<label for="password">Password</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="password" name="password2" id="password2" title="Match the password above" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
					<label for="password2">Confirm Password</label>
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
	$lastname = htmlspecialchars(ucwords($_POST["lastname"]));
	$firstname = htmlspecialchars(ucwords($_POST["firstname"]));
	$username = htmlspecialchars($_POST["username"]);
	$password1 = htmlspecialchars(md5($_POST["password1"]));
	$password2 = htmlspecialchars(md5($_POST["password2"]));

	if ($password1 == $password2) {

		$sql = "INSERT INTO admin_list
			(
				lastname,
				firstname,
				username,
				password
			)
			VALUES
			(
				'$lastname',
				'$firstname',
				'$username',
				'$password1'
			)";

		$res = mysqli_query($conn, $sql);

		if ($res) {
			//To show display messege once data has been inserted
			$_SESSION['add'] = "
				<div class='alert alert--success' id='alert'>
                    <div class='alert__message'>
                        Admin Profile Created Successfully
                    </div>
                </div>
			";

			//Redirecting page to manage admin
			header("location:" . SITEURL .	'admin/admin_manage/admin_manage.php');
		} else {
			//To show display messege once data has been inserted
			$_SESSION['add'] = "
				<div class='alert alert--danger' id='alert'>
					<div class='alert__message'>	
						Failed to Create Admin Profile
					</div>
				</div>
			";

			//Redirecting page to add admin
			header("location:" . SITEURL .	'admin/admin_manage/add_admin.php');
		}
	} else {
		$_SESSION['add'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Password Did Not Match
				</div>
			</div>
		";

		//Redirecting page to add admin
		header("location:" . SITEURL . 'admin/admin_manage/add_admin.php');
	}
}

?>