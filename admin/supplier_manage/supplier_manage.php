<?php include '../partials/head.php'; ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Supplier Profile</h1>
		<?php
		if (isset($_SESSION['add'])) {	//Displaying session message
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

		if (isset($_SESSION['no_supplier_id_found'])) {
			echo $_SESSION['no_supplier_id_found'];
			unset($_SESSION['no_supplier_id_found']);
		}

		if (isset($_SESSION['no_supplier_data_found'])) {
			echo $_SESSION['no_supplier_data_found'];
			unset($_SESSION['no_supplier_data_found']);
		}
		?>

		<div>
			<a href="<?php echo SITEURL; ?>admin/supplier_manage/add_supplier.php" class="btn btn-first">Add</a>
			<!--Button for add admin-->
		</div>

		<table>
			<tr>
				<th>ID</th>
				<th>Lastname</th>
				<th>Firstname</th>
				<th>Contact Number</th>
				<th>Email</th>
				<th>Address</th>
				<th>Country</th>
				<th>Postal Code</th>
				<th>Active</th>
				<th>Actions</th>

			</tr>

			<?php
			//Selecting all from table admin.
			$sql = "SELECT * from suppliers ORDER BY supplier_id DESC";
			//Executiong the query
			$res = mysqli_query($conn, $sql);

			if ($res) {	//Count rows
				$count = mysqli_num_rows($res);
				//Creating a variable and assign the value.
				$ID = 1;

				if ($count > 0) {	//Using while loop to get all of the data from database.
					//It will run as long as there are data in database.
					while ($rows = mysqli_fetch_assoc($res)) {
						$supplier_id = $rows['supplier_id'];
						$supplier_lastname = $rows['supplier_lastname'];
						$supplier_firstname = $rows['supplier_firstname'];
						$contact_number = $rows['contact_number'];
						$email = $rows['email'];
						$address = $rows['address'];
						$country = $rows['country'];
						$postal_code = $rows['postal_code'];
						$active = $rows['active'];

						//Display the values in the table
			?>
						<tr>
							<td><?php echo $ID++; ?></td>
							<td><?php echo $supplier_lastname; ?></td>
							<td><?php echo $supplier_firstname; ?></td>
							<td><?php echo $contact_number; ?></td>
							<td><?php echo $email; ?></td>
							<td><?php echo $address; ?></td>
							<td><?php echo $country; ?></td>
							<td><?php echo $postal_code; ?></td>
							<td><?php echo $active; ?></td>
							<td>
								<a href="<?php echo SITEURL; ?>admin/supplier_manage/update_supplier.php?supplier_id=<?php echo $supplier_id; ?>" class="btn btn-second">Update</a>
								<a href="<?php echo SITEURL; ?>admin/supplier_manage/delete_supplier.php?supplier_id=<?php echo $supplier_id; ?>" class="btn btn-third">Delete</a>
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