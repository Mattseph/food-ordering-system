<?php include '../partials/head.php'; ?>

<div class="main-content">
	<?php

	if (isset($_SESSION['update'])) {
		echo $_SESSION['update'];
		unset($_SESSION['update']);
	}

	if (isset($_SESSION['no_orderid_found'])) {
		echo $_SESSION['no_orderid_found'];
		unset($_SESSION['no_orderid_found']);
	}

	?>
	<div class="wrapper">
		<h1>Order Management</h1>
		<!--Header-->
		<table>
			<tr>
				<th>Order ID</th>
				<th>Lastname</th>
				<th>Firstname</th>
				<th>Contact Number</th>
				<th>Delivery Address </th>
				<th>Postal Code</th>
				<th>Rider ID</th>
				<th>Food ID</th>
				<th>Quantity</th>
				<th>Total</th>
				<th>Mode of Payment</th>
				<th>Order Date</th>
				<th>Status</th>
				<th class="no-border">Actions</th>
			</tr>

			<?php
			//Create a Query
			$sql = "SELECT * from order_details ORDER BY order_date DESC";
			//Execution of the query
			$res = mysqli_query($conn, $sql);

			//Check whether the query is successfully executed
			if ($res) {
				//Count rows of the result
				$count = mysqli_num_rows($res);
				//Creating a variable and assign the value.

				if ($count > 0) {
					//Using while loop to get all of the data from database.
					//It will run as long as there are data in database.
					while ($rows = mysqli_fetch_assoc($res)) {
						$order_id = $rows['order_id'];
						$lastname = $rows['customer_lastname'];
						$firstname = $rows['customer_firstname'];
						$contact_number = $rows['contact_number'];
						$delivery_address = $rows['delivery_address'];
						$postal_code = $rows['postalcode'];
						$rider_id = $rows['rider_id'];
						$food_id = $rows['food_id'];
						$quantity = $rows['quantity'];
						$total = $rows['total'];
						$mode_of_payment = $rows['mode_of_payment'];
						$order_date = $rows['order_date'];
						$status = $rows['status'];


						//Display the values in the table
			?>
						<tr>
							<td><?php echo $order_id; ?></td>
							<td><?php echo $lastname; ?></td>
							<td><?php echo $firstname; ?></td>
							<td><?php echo $contact_number; ?></td>
							<td><?php echo $delivery_address; ?></td>
							<td><?php echo $postal_code; ?></td>
							<td><?php echo $rider_id; ?></td>
							<td><?php echo $food_id; ?></td>
							<td><?php echo $quantity; ?></td>
							<td><?php echo $total; ?></td>
							<td><?php echo $mode_of_payment; ?></td>
							<td><?php echo $order_date; ?></td>
							<td><?php echo $status; ?></td>
							<td class="no-border">
								<a href="<?php echo SITEURL; ?>admin/order_manage/update_order.php?order_id=<?php echo $order_id; ?>" class="btn btn-second">Update</a>
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