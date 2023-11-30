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

	if (isset($_SESSION['no_category_data_found'])) {
		echo $_SESSION['no_category_data_found'];
		unset($_SESSION['no_category_data_found']);
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
			$categoryQuery = "SELECT * from category_list ORDER BY category_id DESC";
			$categoryStatement = $pdo->query($categoryQuery);
			$categoryCount = $categoryStatement->rowCount();

			$ID = 1;
			if ($categoryCount > 0) {
				$categories = $categoryStatement->fetchAll(PDO::FETCH_ASSOC);
				foreach ($categories as $category) {
					$category_id = $category['category_id'];
					$category_name = $category['category_name'];
					$image_name = $category['image_name'];
					$active = $category['active'];

			?>
					<tr>
						<td><?php echo $ID++; ?></td>
						<td><?php echo $category_name; ?></td>
						<td>
							<?php
							if (isset($image_name)) {
							?>
								<img src="../../images/category/<?php echo $image_name ?>" width="70px" height="70px">
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