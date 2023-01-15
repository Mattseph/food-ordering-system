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

	if (isset($_SESSION['pass_not_match'])) {
		echo $_SESSION['pass_not_match'];
		unset($_SESSION['pass_not_match']);
	}

	if (isset($_SESSION['user_not_found'])) {
		echo $_SESSION['user_not_found'];
		unset($_SESSION['user_not_found']);
	}

	if (isset($_SESSION['change_pass'])) {
		echo $_SESSION['change_pass'];
		unset($_SESSION['change_pass']);
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
				<th>Lastname</th>
				<th>Firstname</th>
				<th>Username</th>
				<th>Actions</th>
			</tr>

			<?php
			//Selecting all from table admin.
			$sql = "SELECT * from admin_list ORDER BY admin_id DESC";
			//Executiong the query
			$res = mysqli_query($conn, $sql);

			if ($res) {	//Count rows
				$count = mysqli_num_rows($res);
				//Creating a variable and assign the value.
				$serial = 1;

				if ($count > 0) {	//Using while loop to get all of the data from database.
					//It will run as long as there are data in database.
					while ($rows = mysqli_fetch_array($res)) {
						$admin_id = $rows['admin_id'];
						$lastname = $rows['lastname'];
						$firstname = $rows['firstname'];
						$username = $rows['username'];
						//Display the values in the table
			?>
						<tr>
							<td><?php echo $serial++; ?></td>
							<td><?php echo $lastname; ?></td>
							<td><?php echo $firstname; ?></td>
							<td><?php echo $username; ?></td>
							<td>
								<a href="<?php echo SITEURL; ?>admin/admin_manage/update_admin.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-second">Update</a>
								<a href="<?php echo SITEURL; ?>admin/admin_manage/delete_admin.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-third">Delete</a>
								<a href="<?php echo SITEURL; ?>admin/admin_manage/update_password.php?admin_id=<?php echo $admin_id; ?>" class="btn btn-first">Change Password</a>
							</td>
						</tr>
			<?php
					}
				}
			}
			?>
		</table>
	</div>
</div>