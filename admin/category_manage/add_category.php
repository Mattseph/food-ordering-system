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
			$category_name = htmlspecialchars(ucwords($_POST['categoryname']));

			if (filter_has_var(INPUT_POST, 'active')) {
				$active = htmlspecialchars($_POST['active']);
			} else {
				$active = "No";
			}


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
						header('location:' . SITEURL . 'admin/category_manage/add_category.php');
						die();
					}
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
					'$category_name', 
					'$image_name',
					'$active'
				)";

			$res = mysqli_query($conn, $sql);

			if ($res) {
				$_SESSION['add'] = "<div id='message' class='success category-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Category Added Successfully</span></div>";

				header('location:' . SITEURL . 'admin/category_manage/category_manage.php');
			} else {
				$_SESSION['add'] = "<div id='message' class='fail category-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Add Category</span></div>";

				header('location:' . SITEURL . 'admin/category_manage/add_category.php');
			}
		}
		?>
	</div>

	<div class="form-background">
		<img src="../../images/admin-bg/categories-background.svg" alt="category-background" />
	</div>
</div>
