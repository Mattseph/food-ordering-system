<?php
include '../partials/head.php';
?>

<div class="form">

	<?php
	if (filter_has_var(INPUT_GET, 'category_id')) {
		$clean_categoryid = filter_var($_GET['category_id'], FILTER_SANITIZE_NUMBER_INT);
		$category_id = filter_var($clean_categoryid, FILTER_VALIDATE_INT);

		$sql = "SELECT * FROM category_list WHERE category_id = $category_id";

		$res = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($res);

		if ($count === 1) {
			$row = mysqli_fetch_assoc($res);

			$category_name = htmlspecialchars($row['category_name']);
			$current_image = htmlspecialchars($row['image_name']);
			$active = htmlspecialchars($row['active']);
		} else {
			$_SESSION['no_category_found'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Category Not Found</span></div>";
			header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
		}
	} else {
		$_SESSION['no_category_found'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Category ID not Found</span></div>";
		header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
	}
	?>

	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="crud">
			<h2>Update Category</h2>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="categoryname" id="categoryname" value="<?php echo $category_name; ?>" required autofocus>
					<label for="categoryname">Category Name: </label>
				</div>
			</div>


			<div class="form-group">
				<div class="current-image">
					<label for="">Current Image: </label>
					<?php
					if ($current_image != "") {
					?>
						<img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="180px" height="200px" style=border-radius:15px>
					<?php
					} else {
						echo "<div class = 'failed'>No Image</div>";
					}
					?>
				</div>
			</div>

			<div class="form-group">
				<div class="file">
					<label for="image">New Image: </label>
					<input type="file" name="image" width="200px" height="175px" style=border-radius:15px>
				</div>
			</div>


			<div class="form-group">
				<div class="active">
					<label for="active">Active: </label>
					<div>
						<label for="yes">Yes:</label>
						<input <?php if ($active == "Yes") {
									echo "checked";
								} ?> type="radio" id="yes" name="active" value="Yes">
					</div>
					<div>
						<label for="no">No: </label>
						<input <?php if ($active == "No") {
									echo "checked";
								} ?> type="radio" id="no" name="active" value="No">
					</div>
				</div>
			</div>

			<div>
				<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
				<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
				<button type="submit" name="submit" class="btn">Update Category</button>
			</div>
		</form>

		<?php
		if (filter_has_var(INPUT_POST, 'submit')) {
			$clean_categoryid = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
			$category_id = filter_var($clean_categoryid, FILTER_VALIDATE_INT);

			$category_name = htmlspecialchars(ucwords($_POST['categoryname']));
			$current_image = htmlspecialchars($_POST['current_image']);
			$active = htmlspecialchars($_POST['active']);


			if (isset($_FILES['image']['name'])) {
				$image_name = $_FILES['image']['name'];

				if ($image_name != "") {
					$image_name_parts = explode('.', $image_name);
					$ext = end($image_name_parts);
					$image_name = "Category_Image_" . rand(000, 999) . '.' . $ext;
					$source_path = $_FILES['image']['tmp_name'];
					$destination_path = "../../images/category/" . $image_name;
					$upload = move_uploaded_file($source_path, $destination_path);

					if ($upload == false) {
						$_SESSION['upload'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Upload Image</span></div>";
						header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
						die();
					}
					if ($current_image != "") {
						$remove_path = "../../images/category/" . $current_image;

						$remove = unlink($remove_path);

						if ($remove == false) {
							$_SEESION['remove_failed'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Remove the Current Image</span></div>";

							header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
							die();
						}
					}
				} else {
					$image_name = $current_image;
				}
			} else {
				$image_name = $current_image;
			}

			$sql2 = "UPDATE category_list SET
					category_name = '$category_name',
					image_name = '$image_name',
					active = '$active'
					WHERE category_id = $category_id
				";

			$res2 = mysqli_query($conn, $sql2);

			if ($res2) {
				$_SESSION['update'] = "<div id='message' class='success category-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Category Updated Successfully</span></div>";
				header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
			} else {
				$_SESSION['update'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Update Category</span></div>";

				header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
			}
		}
		?>

	</div>

	<div class="form-background">
		<img src="../../images/admin-bg/categories-background.svg" alt="category-background" />
	</div>
</div>