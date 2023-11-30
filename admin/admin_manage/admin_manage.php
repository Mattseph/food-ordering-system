<?php include "../partials/head.php"; ?>

<div class="main-content">
	<?php
	if (isset($_SESSION['user'])) {	//Displaying session message
		echo $_SESSION['user'];
		unset($_SESSION['user']);
	}

	if (isset($_SESSION['add'])) //Checking whether the session is set or not
	{	//DIsplaying session message
		echo $_SESSION['add'];
		//Removing session message
		unset($_SESSION['add']);
	}

	if (isset($_SESSION['delete'])) {
		echo $_SESSION['delete'];
		unset($_SESSION['delete']);
	}

	if (isset($_SESSION['update'])) {
		echo $_SESSION['update'];
		unset($_SESSION['update']);
	}

	if (isset($_SESSION['change_pass_success'])) {
		echo $_SESSION['change_pass_success'];
		unset($_SESSION['change_pass_success']);
	}

	if (isset($_SESSION['no_admin_data_found'])) {
		echo $_SESSION['no_admin_data_found'];
		unset($_SESSION['no_admin_data_found']);
	}
	?>
	<div class="wrapper">
		<!--Header-->
		<h1>Admin Profile</h1>

		<!--Button for add admin-->
		<div>
			<a href="<?php echo SITEURL; ?>admin/admin_manage/add_admin.php" class="btn btn-first">Add</a>
		</div>

		<table>
			<tr>
				<th>Admin Id</th>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Actions</th>
			</tr>

			<?php
			//Selecting all from table admin.-
			$userAdmin = "SELECT * FROM users WHERE user_role = :role ORDER BY user_id";
			//Executiong the query
			$adminStatement = $pdo->prepare($userAdmin);
			$adminStatement->bindValue(':role', 'Administrator');
			$adminStatement->execute();
			$adminCount = $adminStatement->rowCount();

			if ($adminCount > 0) {
				//Creating a variable and assign the value.
				$serial = 1;
				//Using foreach loop to get all of the data from database.
				//It will run as long as there are data in database.
				while ($admin = $adminStatement->fetch(PDO::FETCH_ASSOC)) {
					$admin_id = $admin['user_id'];
					$lastname = $admin['user_lastname'];
					$firstname = $admin['user_firstname'];
					$username = $admin['user_username'];
					$email = $admin['user_email'];
					//Display the values in the table
			?>
					<tr>
						<td><?php echo $serial++; ?></td>
						<td><?php echo $lastname . ', ' . $firstname; ?></td>
						<td><?php echo $username; ?></td>
						<td><?php echo $email; ?></td>
						<td>
							<a href="<?php echo SITEURL; ?>admin/admin_manage/update_admin.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-second">Update</a>
							<a href="<?php echo SITEURL; ?>admin/admin_manage/delete_admin.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-third">Delete</a>
							<a href="<?php echo SITEURL; ?>admin/admin_manage/update_password.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-first">Change Password</a>
						</td>
					</tr>
			<?php
				}
			}
			?>
		</table>
	</div>
</div>