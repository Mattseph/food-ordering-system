<?php

include '../partials/head.php';

?>

<div class="main-content">
	<?php
	if (isset($_SESSION['add'])) //Checking whether the session is set or not
	{	//Displaying session message
		echo $_SESSION['add'];
		//Removing session message
		unset($_SESSION['add']);
	}

	if (isset($_SESSION['remove'])) {
		echo $_SESSION['remove'];
		unset($_SESSION['remove']);
	}

	if (isset($_SESSION['delete'])) {
		echo $_SESSION['delete'];
		unset($_SESSION['delete']);
	}

	if (isset($_SESSION['no_category_found'])) {
		echo $_SESSION['no_category_found'];
		unset($_SESSION['no_category_found']);
	}

	if (isset($_SESSION['update'])) {
		echo $_SESSION['update'];
		unset($_SESSION['update']);
	}

	if (isset($_SESSION['upload'])) {
		echo $_SESSION['upload'];
		unset($_SESSION['upload']);
	}

	if (isset($_SESSION['remove_failed'])) {
		echo $_SESSION['remove_failed'];
		unset($_SESSION['remove_failed']);
	}
	?>
	<div class="wrapper">
		<h1>Category Management</h1>

		<div>
			<a href="<?php echo SITEURL; ?>admin/category_manage/add_category.php" class="btn btn-first">Add</a>
			<!--Button for add category-->
		</div>

		<table class="tbl_Full">
			<!--Creating Table-->
			<tr>
				<!--Table Row-->
				<th>Category Id</th>
				<th>Category Name</th>
				<th>Image</th>
				<th>Active</th>
				<th>Actions</th>
			</tr>

			<?php
			$sql = "SELECT * from category_list";
			$res = mysqli_query($conn, $sql);
			$count = mysqli_num_rows($res);

			$IDD = 1;
			if ($count > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$category_id = $row['category_id'];
					$category_name = $row['category_name'];
					$image_name = $row['image_name'];
					$active = $row['active'];

			?>
					<tr>
						<td><?php echo $IDD++; ?></td>
						<td><?php echo $category_name; ?></td>
						<td>
							<?php
							if ($image_name != "") {
							?>
								<img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name ?>" width="70px">
							<?php
							} else {
								echo "<div class='fail category-message'>No Image</div>";
							}
							?>
						</td>
						<td><?php echo $active; ?></td>
						<td>
							<a href="<?php echo SITEURL; ?>admin/category_manage/update_category.php?category_id=<?php echo $category_id; ?>" class="btn btn-second">Update</a>
							<a href="<?php echo SITEURL; ?>admin/category_manage/delete_category.php?category_id=<?php echo $category_id; ?>&image_name=<?php echo $image_name; ?>" class='btn btn-third'>Delete</a>
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