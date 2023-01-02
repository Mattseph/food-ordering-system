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

	if (isset($_SESSION['upload'])) {
		echo $_SESSION['upload'];
		unset($_SESSION['upload']);
	}

	if (isset($_SESSION['unauthorize'])) {
		echo $_SESSION['unauthorize'];
		unset($_SESSION['unauthorize']);
	}

	if (isset($_SESSION['update'])) {
		echo $_SESSION['update'];
		unset($_SESSION['update']);
	}

	if (isset($_SESSION['no_foodid_found'])) {
		echo $_SESSION['no_foodid_found'];
		unset($_SESSION['no_foodid_found']);
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
				<th>Image</th>
				<th>Active</th>
				<th>Actions</th>
			</tr>

			<?php
			$sql = "SELECT * from food_list";
			$res = mysqli_query($conn, $sql);
			$count = mysqli_num_rows($res);
			$IDD = 1;

			if ($count > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$food_id = $row['food_id'];
					$food_name = $row['food_name'];
					$price = $row['food_price'];
					$image_name = $row['image_name'];
					$active = $row['active'];


			?>
					<tr>
						<td><?php echo $IDD++; ?></td>
						<td><?php echo $food_name; ?></td>
						<td>$<?php echo $price; ?></td>
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