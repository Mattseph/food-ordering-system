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
					<label for="foodname">Food Name</label>
				</div>
			</div>

			<div class="description">
				<div class="placeholder">
					<textarea name="description" id="description" required pattern="[A-Za-z0-9 -]+"></textarea>
					<label for="description">Description</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="number" step="0.01" name="foodprice" id="price" required>
					<label for="price">Price</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="number" step="1" name="available_quantity" id="available_quantity" required>
					<label for="available_quantity">Available Quantity</label>
				</div>
			</div>

			<div class="form-group">
				<div class="file">
					<label for="image">Select </label>
					<input type="file" name="image">
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<select name="category" required>
						<?php

						$categoryQuery = "SELECT * FROM category_list WHERE active = :active";
						$categoryStatement = $pdo->prepare($categoryQuery);
						$categoryStatement->bindValue(':active', 'Yes');
						$categoryStatement->execute();

						$categoryCount = $categoryStatement->rowCount();

						if ($categoryCount > 0) {
							while ($category = $categoryStatement->fetch(PDO::FETCH_ASSOC)) {
								$category_id = $category['category_id'];
								$category_name = $category['category_name'];

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
					<label for="category">Category </label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<select name="supplier" required>
						<?php
						$supplierQuery = "SELECT * FROM suppliers WHERE active = :active";
						$supplierStatement = $pdo->prepare($supplierQuery);
						$supplierStatement->bindValue(':active', 'Yes');
						$supplierStatement->execute();
						$supplierCount = $supplierStatement->rowCount();

						if ($supplierCount > 0) {
							while ($supplier = $supplierStatement->fetch(PDO::FETCH_ASSOC)) {
								$supplier_id = $supplier['supplier_id'];
								$supplier_lastname = $supplier['supplier_lastname'];
								$supplier_firstname = $supplier['supplier_firstname'];

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
					<label for="supplier">Supplier </label>
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
			$available_quantity = htmlspecialchars($_POST['available_quantity']);


			if (filter_has_var(INPUT_POST, 'active')) {
				$active = htmlspecialchars($_POST['active']);
			} else {
				$active = "No";
			}

			$image_name = $_FILES['image']['name'];
			$temp_name = $_FILES['image']['tmp_name'];

			$image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
			$allowed_extension = ['jpg', 'jpeg', 'png'];
			if ($image_name) {

				if (!in_array($image_extension, $allowed_extension)) {
					$_SESSION['error-extension'] = "Only jpg, jpeg and png image extension are allowed";

					header('location:' . SITEURL . 'admin/food_manage/add_food.php');
					exit();
				} else {
					$upload_name = $image_name . '.png';
					$destination_path = "../../images/food/" . $upload_name;
					move_uploaded_file($temp_name, $destination_path);
					$image_url = $upload_name;
				}
			} else {
				$image_url = "";
				echo "<script>alert('Failed to Update Food')</script>";
			}

			$insertQuery = "INSERT INTO food_list
				( 
					category_id,
					supplier_id,
					food_name,
					description,
					food_price,
					available_quantity,
					image_name,
					active
				)
				VALUES
				(
					:category_id,
					:supplier_id,
					:food_name, 
					:description,
					:food_price,
					:available_quantity,
					:image_name,
					:active
				)";

			$insertfoodStatement = $pdo->prepare($insertQuery);
			$insertfoodStatement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
			$insertfoodStatement->bindParam(':supplier_id', $category_id, PDO::PARAM_INT);
			$insertfoodStatement->bindParam(':food_name', $food_name);
			$insertfoodStatement->bindParam(':description', $description);
			$insertfoodStatement->bindParam(':food_price', $food_price);
			$insertfoodStatement->bindParam(':available_quantity', $available_quantity);
			$insertfoodStatement->bindParam(':image_name', $image_url);
			$insertfoodStatement->bindParam(':active', $active);

			if ($insertfoodStatement->execute()) {
				$_SESSION['add'] = "
					<div class='alert alert--success' id='alert'>
						<div class='alert__message'>
							Food Added Successfully
						</div>
					</div>
				";

				header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
			} else {
				$_SESSION['add'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Failed to Add Food
						</div>
					</div>
				";
				header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
			}
		}
		?>
	</div>
</div>