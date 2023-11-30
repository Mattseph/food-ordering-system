<?php include '../partials/head.php'; ?>

<div class="main-content">
	<?php

	if (isset($_SESSION['update'])) {
		echo $_SESSION['update'];
		unset($_SESSION['update']);
	}

	if (isset($_SESSION['no_order_id_found'])) {
		echo $_SESSION['no_orderid_found'];
		unset($_SESSION['no_orderid_found']);
	}

	?>
	<div class="wrapper">
		<h1>Order Status Management</h1>
		<!--Header-->
		<table>
			<tr>
				<th>Order ID</th>
				<th>Lastname</th>
				<th>Firstname</th>
				<th>Contact Number</th>
				<th>Delivery Address </th>
				<th>Rider ID</th>
				<th>Food Name</th>
				<th>Quantity</th>
				<th>Total</th>
				<th>Mode of Payment</th>
				<th>Order Date</th>
				<th>Status</th>
				<th class="no-border">Actions</th>
			</tr>

			<?php
			//Create a Query
			$orderQuery = "SELECT * from order_details ORDER BY order_date DESC";
			//Execution of the query
			$orderStatement = $pdo->query($orderQuery);
			$orders = $orderStatement->fetchAll(PDO::FETCH_ASSOC);

			if ($orders) {
				//Using foreach loop to get all of the data from database.
				//It will run as long as there are data in database.
				foreach ($orders as $order) {
					$order_id = $order['order_id'];
					$lastname = $order['customer_lastname'];
					$firstname = $order['customer_firstname'];
					$contact_number = $order['contact_number'];
					$delivery_address = $order['delivery_address'];
					$rider_id = $order['rider_id'];
					$food_id = $order['food_id'];
					$quantity = $order['quantity'];
					$total = $order['total'];
					$mode_of_payment = $order['mode_of_payment'];
					$order_date = $order['order_date'];
					$status = $order['status'];

					$foodQuery = "SELECT food_name FROM food_list WHERE food_id = :food_id";
					$foodStatement = $pdo->prepare($foodQuery);
					$foodStatement->bindParam(':food_id', $food_id);
					$foodStatement->execute();
					$foodCount = $foodStatement->rowCount();

					if ($foodCount > 0) {
						$food = $foodStatement->fetch(PDO::FETCH_ASSOC);

						$food_name = $food['food_name'];

						//Display the values in the table
			?>
						<tr>
							<td><?php echo $order_id; ?></td>
							<td><?php echo $lastname; ?></td>
							<td><?php echo $firstname; ?></td>
							<td><?php echo $contact_number; ?></td>
							<td><?php echo $delivery_address; ?></td>
							<td><?php echo $rider_id; ?></td>
							<td><?php echo $food_name; ?></td>
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