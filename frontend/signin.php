<?php
include('../configuration.php');
?>

<html>

<head>
	<title>Sign in - Quick Bites</title>
	<link rel="stylesheet" href="../css/main.css">
	<link rel="icon" type="image/jpg" href="../images/logo/logo.jpg">
	<script src="../js/timer.js" type="text/javascript"></script>
</head>
<?php
if (isset($_SESSION['incorrect-input'])) {
	echo $_SESSION['incorrect-input'];
	unset($_SESSION['incorrect-input']);
}

if (isset($_SESSION['error_login'])) {
	echo $_SESSION['error_login'];
	unset($_SESSION['error_login']);
}

if (isset($_SESSION['add'])) //Checking whether the session is set or not
{	//DIsplaying session message
	echo $_SESSION['add'];
	//Removing session message
	unset($_SESSION['add']);
}


$input = [];
$error = [];
?>


<body>
	<div class="signin-form">
		<div class="signin-background">
			<img src="../images/signin/signin.jpg" alt="login-backgrou
			nd" />
		</div>

		<div class="signin-container">
			<div class="signin-row">
				<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" autocomplete="off" class="signin">

					<h2 style="position: relative; top: -30px;">Sign in</h2>
					<div class="signin-form-group">
						<div class="signin-img-container">
							<img src="../images/signin/username.png" alt="profile">
						</div>
						<div class="placeholder">
							<input type="text" name="username" id="username" title="Please enter correct username" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{5,}" value="<?php echo $input['username'] ?? '' ?>" required autofocus>
							<label for="username">Username</label>
							<small style="color: red"><?php echo $error['username'] ?? '' ?></small>
						</div>
					</div>

					<div class="signin-form-group">
						<div class="signin-img-container">
							<img src="../images/signin/password.png" alt="lock">
						</div>
						<div class="placeholder">
							<input type="password" name="password" id="password" title="Please enter correct password" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" value="<?php echo $input['password'] ?? '' ?>" required>
							<label for="password">Password</label>
							<small style="color: red"><?php echo $error['password'] ?? ''; ?></small>
						</div>
					</div>

					<div class="signin-form-button">
						<button type="submit" name="submit" class="btn"> Sign in </button>
					</div>
					<div class="signout-form-button">
						<div>Doesn't have an account yet? <a href="signup.php">Sign Up</a></div>
					</div>
				</form>
			</div>

		</div>
	</div>
</body>

</html>

<?php


$user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$input['username'] = $user;

$pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
$input['password'] = $pass;

if ($user && $pass) {
	$username = htmlspecialchars($_POST['username']);
	$password = md5($_POST['password']);

	//2.SQL to check whether the user with username and password exists or not
	$sql = "SELECT * FROM admin_list WHERE username='$username' AND password='$password'";
	$sql2 = "SELECT * FROM users WHERE user_username='$username' AND user_password ='$password'";

	$res = mysqli_query($conn, $sql);
	$res2 = mysqli_query($conn, $sql2);

	$count = mysqli_num_rows($res);
	$count2 = mysqli_num_rows($res2);

	if ($count === 1) {
		$row = mysqli_fetch_assoc($res);

		$_SESSION['user'] = "<div id='message' class='success signin-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Welcome Admin {$username}!</span></div>";

		$_SESSION['user_id'] = $row['admin_id'];

		header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
	} elseif ($count2 === 1) {
		$row2 = mysqli_fetch_assoc($res2);

		$_SESSION['user'] = "<div id='message' class='success signin-message'><img src='images/logo/successful.svg' alt='successful' class='successful'><span>Welcome User {$username}!</span></div>";

		$_SESSION['user_id'] = $row2['user_id'];

		header('location:' . SITEURL);
	} else {
		$_SESSION['incorrect-input'] = "<div id='message' class='fail signin-message'><img src='../images/logo/warning.svg' alt='warning' class='warning'><span>Sign in failed, please input correct username and password</span></div>";
		header('location:' . SITEURL . 'frontend/signin.php');
	}
} else {
	$error['username'] = 'Please enter valid username.';
	$error['password'] = 'Please enter valid password.';
}

?>