<?php

include '../partials/head.php';

?>

<div class="main-content">
	<?php
	if (isset($_SESSION['add'])) {
		echo $_SESSION['add'];
		unset($_SESSION['add']);
	}


	if (isset($_SESSION['delete'])) {
		echo $_SESSION['delete'];
		unset($_SESSION['delete']);
	}

	if (isset($_SESSION['upload_photo_failed'])) {
		echo $_SESSION['upload_photo_failed'];
		unset($_SESSION['upload_photo_failed']);
	}

	if (isset($_SESSION['remove_photo_failed'])) {
		echo $_SESSION['remove_photo_failed'];
		unset($_SESSION['remove_photo_failed']);
	}

	if (isset($_SESSION['update'])) {
		echo $_SESSION['update'];
		unset($_SESSION['update']);
	}

	if (isset($_SESSION['no_food_id_found'])) {
		echo $_SESSION['no_food_id_found'];
		unset($_SESSION['no_food_id_found']);
	}

	if (isset($_SESSION['no_food_data_found'])) {
		echo $_SESSION['no_food_data_found'];
		unset($_SESSION['no_food_data_found']);
	}
	?>
	<div class="wrapper">
		<h1>Food Management</h1>
		<div>
			<a href="<?php echo SITEURL; ?>admin/food_manage/add_food.php" class="btn btn-first">Add</a>
			<!--Button for add admin-->
		</div>
		<table>
			<tr>
				<th>Food ID</th>
				<th>Food Name</th>
				<th>Price</th>
				<th>Available Quantity</th>
				<th>Image</th>
				<th>Active</th>
				<th>Actions</th>
			</tr>

			<?php
			$foodQuery = "SELECT * from food_list ORDER BY food_id DESC";
			$foodStatement = $pdo->query($foodQuery);
			$foods = $foodStatement->fetchAll(PDO::FETCH_ASSOC);
			$ID = 1;

			if ($foods) {
				foreach ($foods as $food) {
					$food_id = $food['food_id'];
					$food_name = $food['food_name'];
					$price = $food['food_price'];
					$available_quantity = $food['available_quantity'];
					$image_name = $food['image_name'];
					$active = $food['active'];


			?>
					<tr>
						<td><?php echo $ID++; ?></td>
						<td><?php echo $food_name; ?></td>
						<td>$<?php echo $price; ?></td>
						<td><?php echo $available_quantity; ?></td>
						<td>
							<?php
							if ($image_name == "") {
								echo "<div style=color:red>No Image</div>";
							} else {
							?>
								<img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="70px">
							<?php
							}
							?>
						</td>
						<td><?php echo $active; ?></td>
						<td>
							<a href="<?php echo SITEURL ?>admin/food_manage/update_food.php?food_id=<?php echo $food_id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-second">Update</a>
							<a href="<?php echo SITEURL ?>admin/food_manage/delete_food.php?food_id=<?php echo $food_id; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-third">Delete</a>
						</td>
					</tr>
			<?php
				}
			}
			?>
		</table>
	</div>
</div>
</div>