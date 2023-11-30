<?php
session_start();
include '../configuration.php';
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

if (isset($_SESSION['signin-required'])) {
	echo $_SESSION['signin-required'];
	unset($_SESSION['signin-required']);
}
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
							<input type="text" name="username" id="username" title="Please enter correct username" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{5,}" value="" required autofocus>
							<label for="username">Username</label>
						</div>
					</div>

					<div class="signin-form-group">
						<div class="signin-img-container">
							<img src="../images/signin/password.png" alt="lock">
						</div>
						<div class="placeholder">
							<input type="password" name="password" id="password" title="Please enter correct password" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" value="" required>
							<label for="password">Password</label>

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


if (filter_has_var(INPUT_POST, 'submit')) {
	$username = htmlspecialchars($_POST['username']);
	$password = md5($_POST['password']);

	//2.SQL to check whether the user with username and password exists or not

	$userQuery = "SELECT * FROM users WHERE user_username = :username AND user_password = :password";
	$userStatement = $pdo->prepare($userQuery);
	$userStatement->bindParam(':username', $username);
	$userStatement->bindParam(':password', $password);
	$userStatement->execute();
	$userCount = $userStatement->rowCount();


	if ($userCount === 1) {
		$user = $userStatement->fetch(PDO::FETCH_ASSOC);
		if ($user['user_role'] === 'Customer') {
			$_SESSION['user'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Sign in Successfully
				</div>
			</div>
			";

			$_SESSION['user_id'] = $user['user_id'];

			header('location:' . SITEURL);
		} else if ($user['user_role'] === 'Administrator') {
			$_SESSION['user'] = "<div id='message' class='success signin-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Welcome Admin {$username}!</span></div>";

			$_SESSION['user'] = "
			<div class='alert alert--success' id='alert'>
				<div class='alert__message'>
					Welcome Admin {$username}!
				</div>
			</div>";
			$_SESSION['user_id'] = $user['user_id'];
			header('location:' . SITEURL . 'admin/admin_manage/admin_manage.php');
		}
	} else {
		$_SESSION['incorrect-input'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Sign in Failed, Please Enter Correct Username and Password.
				</div>
			</div>
		";
		header('location:' . SITEURL . 'customer/signin.php');
	}
}
?>