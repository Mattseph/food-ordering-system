<?php include '../partials/head.php'; ?>
<div class="form">

	<?php
	if (isset($_SESSION['add'])) //Checking whether the session is set or not
	{	//DIsplaying session message
		echo $_SESSION['add'];
		//Removing session message
		unset($_SESSION['add']);
	}

	if (isset($_SESSION['upload'])) //Checking whether the session is set or not
	{	//DIsplaying session message
		echo $_SESSION['upload'];
		//Removing session message
		unset($_SESSION['upload']);
	}
	?>
	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="crud">
			<h2>Add Category</h2>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="categoryname" id="categoryname" required autofocus>
					<label for="categoryname">Category Name </label>
				</div>
			</div>

			<div class="form-group">
				<div class="file">
					<label for="image">Select Image: </label>
					<input type="file" name="image" accept="image/*">
				</div>
				<small>
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
						<label for="yes">Yes: </label>
						<input type="radio" id="yes" name="active" value="Yes">
					</div>
					<div>
						<label for="no">No: </label>
						<input type="radio" id="no" name="active" value="No">
					</div>
				</div>
			</div>

			<div>
				<button type="submit" name="submit" class="btn">Add Category</button>
			</div>
		</form>

		<?php

		if (filter_has_var(INPUT_POST, 'submit')) {
			$category_name = htmlspecialchars(ucwords(trim($_POST['categoryname'])));

			if (filter_has_var(INPUT_POST, 'active')) {
				$active = htmlspecialchars($_POST['active']);
			} else {
				$active = "No";
			}
			
			$image_name = $_FILES['image']['name'];
			$temp_name = $_FILES['image']['tmp_name'];

			$allowed_extension = ['jpg', 'png', 'png'];
			$image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

			if ($image_name) {
			

				if (!in_array($image_extension, $allowed_extension)) {
					$_SESSION['error-extension'] = "Only jpg, jpeg and png image extension are allowed";

					header('location:' . SITEURL . 'admin/category_manage/add_category.php');
					exit();
				} else {
					$upload = $category_name . '.png';
					$destination_path = "../../images/category/" . $upload;
					move_uploaded_file($temp_name, $destination_path);
					$image_url = $upload;
				}
			} else {
				$image_name = "";
			}
			$sql = "INSERT INTO category_list
				(
					category_name,
					image_name,
					active
				)
				VALUES
				(
					:category_name, 
					:image_name,
					:active
				)";

			$statement = $pdo->prepare($sql);
			$statement->bindParam(':category_name', $category_name);
			$statement->bindParam(':image_name', $image_url);
			$statement->bindParam(':active', $active);

			if ($statement->execute()) {
				$_SESSION['add'] = "
					<div class='alert alert--success' id='alert'>
						<div class='alert__message'>
							Category Added Successfully
						</div>
					</div>
				";

				header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
			} else {
				$_SESSION['add'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Failed to Add Category
						</div>
					</div>
				";

				header('location:' . SITEURL . 'admin/category_manage/add_category.php');
			}
		}
		?>
	</div>

	<div class="form-background">
		<img src="../../images/admin-bg/categories-background.svg" alt="category-background" />
	</div>
</div>