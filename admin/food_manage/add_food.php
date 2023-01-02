<?php include '../partials/head.php'; ?>
<div class="form">

	<?php

	if (isset($_SESSION['upload'])) {
		echo $_SESSION['upload'];
		unset($_SESSION['upload']);
	}
	?>

	<div class="form-background">
		<img src="../../images/admin-bg/food-background.svg" alt="food-background" />
	</div>

	<div class="row">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" enctype="multipart/form-data" class="crud">
			<h2>Add Food</h2>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="foodname" id="foodname" pattern="[A-Za-z0-9 -]+" required autofocus>
					<label for="foodname">Food Name:</label>
				</div>
			</div>

			<div class="description">
				<div class="placeholder">
					<textarea name="description" id="description" required pattern="[A-Za-z0-9 -]+"></textarea>
					<label for="description">Description:</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="number" step="0.01" name="foodprice" id="price" required>
					<label for="price">Price</label>
				</div>
			</div>

			<div class="form-group">
				<div class="file">
					<label for="image">Select: </label>
					<input type="file" name="image">
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">

					<select name="category" required>
						<?php

						$sql = "SELECT * FROM category_list WHERE active = 'YES'";
						$res = mysqli_query($conn, $sql);
						$count = mysqli_num_rows($res);

						if ($count > 0) {
							while ($row = mysqli_fetch_assoc($res)) {
								$category_id = $row['category_id'];
								$category_name = $row['category_name'];

						?>

								<option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>

							<?php
							}
						} else {
							?>
							<option value="0">No Category Found</option>
						<?php
						}

						?>
					</select>
					<label for="category">Category: </label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<select name="supplier" required>
						<?php
						$sql2 = "SELECT * FROM suppliers WHERE active = 'Yes'";
						$res2 = mysqli_query($conn, $sql2);
						$count2 = mysqli_num_rows($res2);

						if ($count2 > 0) {
							while ($row2 = mysqli_fetch_assoc($res2)) {
								$supplier_id = $row2['supplier_id'];
								$supplier_lastname = $row2['supplier_lastname'];
								$supplier_firstname = $row2['supplier_firstname'];

						?>
								<option value="<?php echo $supplier_id; ?>"><?php echo $supplier_lastname . ', ' . $supplier_firstname; ?></option>

							<?php
							}
						} else {
							?>
							<option value="0">No Supplier Found</option>
						<?php
						}


						?>
					</select>
					<label for="supplier">Supplier: </label>
				</div>
			</div>

			<div class="form-group">
				<div class="active">
					<label for="active">Active:</label>
					<div>
						<label for="yes">Yes</label>
						<input type="radio" id="yes" name="active" value="Yes">
					</div>
					<div>
						<label for="no">No</label>
						<input type="radio" id="no" name="active" value="No">
					</div>
				</div>
			</div>

			<div>
				<button type="submit" name="submit" class="btn">Add Food</button>
			</div>
		</form>

		<?php

		if (filter_has_var(INPUT_POST, 'submit')) {
			$clean_category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			$category_id = filter_var($clean_category_id, FILTER_VALIDATE_INT);

			$clean_supplier_id = filter_var($_POST['supplier'], FILTER_SANITIZE_NUMBER_INT);
			$supplier_id = filter_var($clean_supplier_id, FILTER_VALIDATE_INT);

			$food_name = htmlspecialchars(ucwords($_POST['foodname']));
			$description = htmlspecialchars($_POST['description']);
			$food_price = htmlspecialchars($_POST['foodprice']);


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
					$image_name = "Food_Name_" . rand(000, 999) . '.' . $ext;
					$sourcepath = $_FILES['image']['tmp_name'];
					$destinationpath = "../../images/food/" . $image_name;
					$upload = move_uploaded_file($sourcepath, $destinationpath);

					if ($upload == false) {
						$_SESSION['upload'] = "<div id='message' class='fail food-message'><img src='../../images/logo/warning.svg'alt='warning' class='warning'><span>Failed to Upload Image</div>";
						header('location:' . SITEURL . 'admin/food_manage/add_food.php');
						die();
					}
				}
			} else {
				$image_name = "";
				echo "<script>alert('Failed to Update Food')</script>";
			}

			$sql = "INSERT INTO food_list
				( 
					category_id,
					supplier_id,
					food_name,
					description,
					food_price,
					image_name,
					active
				)
				VALUES
				(
					$category_id,
					$supplier_id,
					'$food_name', 
					'$description',
					$food_price,
					'$image_name',
					'$active'
				)";

			$res = mysqli_query($conn, $sql);

			if ($res) {
				$_SESSION['add'] = "<div id='message' class='success food-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Food Added Successfully</span></div>";

				header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
			} else {
				$_SESSION['add'] = "<div id='message' class='fail food-message'><img src='../../images/logo/warning.svg'alt='warning' class='warning'><span>Failed to Add Food</span></div>";

				header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
			}
		}
		?>
	</div>
</div>