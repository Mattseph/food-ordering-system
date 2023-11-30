<?php
include '../partials/head.php';
?>

<div class="form">

	<?php
	ob_start();
	if (filter_has_var(INPUT_GET, 'category_id')) {
		$clean_categoryid = filter_var($_GET['category_id'], FILTER_SANITIZE_NUMBER_INT);
		$category_id = filter_var($clean_categoryid, FILTER_VALIDATE_INT);

		$categoryQuery = "SELECT * FROM category_list WHERE category_id = :category_id";
		$categoryStatement = $pdo->prepare($categoryQuery);
		$categoryStatement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
		$categoryStatement->execute();

		$categoryCount = $categoryStatement->rowCount();

		if ($categoryCount === 1) {
			$category = $categoryStatement->fetch(PDO::FETCH_ASSOC);

			$category_name = htmlspecialchars($category['category_name']);
			$current_image = htmlspecialchars($category['image_name']);
			$active = htmlspecialchars($category['active']);
		} else {
			$_SESSION['no_category_data_found'] = "
				<div class='alert alert--danger' id='alert'>
					<div class='alert__message'>	
						Category Data Not Found
					</div>
				</div>
			";
			header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
		}
	}
	?>

	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="crud">
			<h2>Update Category</h2>
			<?php
			if (isset($_SESSION['error-update'])) {
				$error = $_SESSION['error-update'];
				unset($_SESSION['error-update']);
				echo $error;
			}
			?>
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
				<small style="color:red">
					<?php
					if (isset($_SESSION['error-extension'])) {
						$error = $_SESSION['error-extension'];
						unset($_SESSION['error-extension']);
						echo $error;
					}
					?>
				</small>
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
				<input type="hidden" name="old_category_name" value="<?php echo $category_name; ?>">
				<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
				<button type="submit" name="submit" class="btn">Update Category</button>
			</div>
		</form>

		<?php
		if (filter_has_var(INPUT_POST, 'submit')) {
			$clean_categoryid = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
			$category_id = filter_var($clean_categoryid, FILTER_VALIDATE_INT);

			$category_name = htmlspecialchars(ucwords(trim($_POST['categoryname'])));
			$current_image = htmlspecialchars($_POST['current_image']);
			$old_category_name = htmlspecialchars($_POST['old_category_name']);
			$active = htmlspecialchars($_POST['active']);


			$new_image_uploaded = false;

			// Get the old file path
			$old_image_path = "../../images/category/" . $current_image;
			$image_name = $_FILES['image']['name'];
			$temp_name = $_FILES['image']['tmp_name'];

			$image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
			$allowed_extension = ['jpg', 'jpeg', 'png'];

			if ($image_name) {

				if (!in_array($image_extension, $allowed_extension)) {
					$_SESSION['error-extension'] = "Only jpg, jpeg and png image extension are allowed";
					header("location: update_category.php?category_id='$category_id'");
					exit();
				} else {
					$upload_name = $category_name . '.png';
					$destination_path = '../../images/category/' . $upload_name;
					move_uploaded_file($temp_name, $destination_path);
					$image_url = $upload_name;
					$new_image_uploaded = true;
				}
			} else {
				$renaned_image_name = $category_name . '.png';
				$new_image_path = "../../images/category/" . $renaned_image_name;
				rename($old_image_path, $new_image_path);
				$image_url = $new_image_path;
			}

			if ($new_image_uploaded && $category_name !== $old_category_name) {
				unlink($old_image_path);
			}



			$categoryUpdate = "UPDATE category_list SET
					category_name = :category_name,
					image_name = :image_name,
					active = :active
					WHERE category_id = :category_id
				";

			$categoryupdateStatement = $pdo->prepare($categoryUpdate);
			$categoryupdateStatement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
			$categoryupdateStatement->bindParam(':category_name', $category_name);
			$categoryupdateStatement->bindParam(':image_name', $image_url);
			$categoryupdateStatement->bindParam(':active', $active);

			if ($categoryupdateStatement->execute()) {
				$_SESSION['update'] = "
				<div class='alert alert--success' id='alert'>
					<div class='alert__message'>
						Category Update Successfully
					</div>
				</div>
			";
				header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
			} else {
				$_SESSION['error-update'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Failed to Update Category
						</div>
					</div>
				";

				header("location:" . SITEURL . "admin/category_manage/update_category.php?category_id='$category_id'");
			}
		}
		ob_end_flush();
		?>

	</div>

	<div class="form-background">
		<img src="../../images/admin-bg/categories-background.svg" alt="category-background" />
	</div>
</div>