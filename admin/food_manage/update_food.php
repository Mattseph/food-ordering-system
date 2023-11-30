<?php
ob_start();
include '../partials/head.php';

if (filter_has_var(INPUT_GET, 'food_id')) {
	$clean_id = filter_var($_GET['food_id'], FILTER_SANITIZE_NUMBER_INT);
	$food_id = filter_var($clean_id, FILTER_VALIDATE_INT);

	$foodQuery = "SELECT * FROM food_list WHERE food_id = :food_id";
	$foodStatement = $pdo->prepare($foodQuery);
	$foodStatement->bindParam(':food_id', $food_id);

	$foodCount = $foodStatement->rowCount();
	
	if ($foodCount === 1) {
		$food = $foodStatement->fetch(PDO::FETCH_ASSOC);

		$current_category = $food['category_id'];
		$current_supplier = $food['supplier_id'];
		$food_name = $food['food_name'];
		$description = $food['description'];
		$price = $food['food_price'];
		$available_quantity = $food['available_quantity'];
		$current_image = $food['image_name'];
		$active = $food['active'];
	} else {
		$_SESSION['no_food_data_found'] = "
			<div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Food Data Not Found
				</div>
			</div>
		";
	}
} else {
	$_SESSION['no_food_id_found'] = "
		<div class='alert alert--danger' id='alert'>
			<div class='alert__message'>	
				Food Id Not Found
			</div>
		</div>
	";
	header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
}
?>

<div class="form">
	<div class="form-background">
		<img src="../../images/admin-bg/food-background.svg" alt="food-background" />
	</div>

	<div class="row">
		<form action="" method="POST" enctype="multipart/form-data" class="crud">

			<h2>Update Food</h2>

			<div class="form-group">
				<div class="placeholder">
					<input type="text" name="foodname" id="foodname" value="<?php echo $food_name; ?>" required autofocus>
					<label for="foodname">Food Name</label>
				</div>
			</div>

			<div class="description">
				<div class="placeholder">
					<textarea id="description" name="description"><?php echo $description; ?></textarea>
					<label for="description">Description</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="number" step="0.01" name="price" id="price" value="<?php echo $price; ?>">
					<label for="price">Price</label>
				</div>
			</div>

			<div class="form-group">
				<div class="placeholder">
					<input type="number" step="1" name="available_quantity" id="available_quantity" value="<?php echo $available_quantity; ?>">
					<label for="available_quantity">Available Quantity</label>
				</div>
			</div>


			<div class="form-group">
				<div class="current-image">
					<label for="">Current Image: </label>
					<?php
					if ($current_image == "") {
						echo "<div class = 'failed'>No Image</div>";
					} else {
					?>
						<img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="180px" height="200px" style=border-radius:15px>
					<?php
					}
					?>
				</div>
			</div>

			<div class="form-group">
				<div class="file">
					<label for="image">New Image: </label>
					<input type="file" name="image" width="200px" height="175px" style=border-radius:15px>
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
								<option <?php if ($current_category === $category_id) {
											echo "Selected";
										}
										?> value="<?php echo $category_id; ?>"><?php echo $category_name; ?>
								</option>
						<?php
							}
						} else {
							echo "<option value = '0'>Category not Available</option>";
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
						$active = 'Yes';
						$supplierQuery = "SELECT * FROM suppliers WHERE active = :active";
						$supplierStatement = $pdo->prepare($supplierQuery);
						$supplierStatement->bindParam(':active', $active);
						$supplierStatement->execute();
						$supplierCount = $supplierStatement->rowCount();

						if ($supplierCount > 0) {
							while ($supplier = $supplierStatement->fetch(PDO::FETCH_ASSOC)) {
								$supplier_id = $supplier['supplier_id'];
								$supplier_lastname = $supplier['supplier_lastname'];
								$supplier_firstname = $supplier['supplier_firstname'];

						?>
								<option <?php if ($current_supplier === $supplier_id) {
											echo "Selected";
										}
										?> value="<?php echo $supplier_id; ?>"><?php echo $supplier_lastname . ', ' . $supplier_firstname; ?>
								</option>
						<?php
							}
						} else {
							echo "<option value=0> No Supplier </option>";
						}
						?>

					</select>
					<label for="supplier">Supplier: </label>
				</div>
			</div>

			<div class="form-group">
				<div class="active">
					<label for="active">Active: </label>
					<div>
						<label for="yes">Yes</label>
						<input <?php if ($active == "Yes") {
									echo "checked";
								} ?> type="radio" id="yes" name="active" value="Yes">
					</div>
					<div>
						<label for="no">No</label>
						<input <?php if ($active == "No") {
									echo "checked";
								} ?> type="radio" id="no" name="active" value="No">
					</div>
				</div>

			</div>
			<div>
				<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
				<input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
				<button type="submit" name="submit" class="btn"> Update Food </button>
			</div>
		</form>

		<?php
		if (filter_has_var(INPUT_POST, 'submit')) {
			$clean_id = filter_var($_POST['food_id'], FILTER_SANITIZE_NUMBER_INT);
			$food_id = filter_var($clean_id, FILTER_VALIDATE_INT);

			$clean_cate_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			$category_id = filter_var($clean_cate_id, FILTER_VALIDATE_INT);

			$clean_supp_id = filter_var($_POST['supplier'], FILTER_SANITIZE_NUMBER_INT);
			$supplier_id = filter_var($clean_supp_id, FILTER_VALIDATE_INT);

			$food_name = htmlspecialchars(ucwords($_POST['foodname']));
			$description = htmlspecialchars($_POST['description']);

			$food_price = htmlspecialchars($_POST['price']);
			$available_quantity = htmlspecialchars($_POST['available_quantity']);

			$current_image = htmlspecialchars($_POST['current_image']);
			$active = htmlspecialchars($_POST['active']);


			$new_image_uploaded = false;

			// Get the old file path
			$old_image_path = "../../images/food/" . $current_image;
			$image_name = $_FILES['image']['name'];
			$temp_name = $_FILES['image']['tmp_name'];

			$image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
			$allowed_extension = ['jpg', 'jpeg', 'png'];

			if ($image_name) {

				if (!in_array($image_extension, $allowed_extension)) {
					$_SESSION['error-extension'] = "Only jpg, jpeg and png image extension are allowed";
					header("location: update_food.php?food_id='$food_id'");
					exit();
				} else {
					$upload_name = $food_name . '.png';
					$destination_path = '../../images/food/' . $upload_name;
					move_uploaded_file($temp_name, $destination_path);
					$image_url = $upload_name;
					$new_image_uploaded = true;
				}
			} else {
				$renaned_image_name = $food_name . '.png';
				$new_image_path = "../../images/food/" . $renaned_image_name;
				rename($old_image_path, $new_image_path);
				$image_url = $new_image_path;
			}

			if ($new_image_uploaded && $food_name !== $old_food_name) {
				unlink($old_image_path);
			}

			$updatefoodQuery = "UPDATE food_list SET
				category_id = :category_id,
				supplier_id = :supplier_id,
				food_name = :food_name,
				description = :description,
				food_price = :food_price,
				available_quantity = :available_quantity,
				image_name = :image_name,
				active = :active
				WHERE food_id = :food_id
			";

			$updatefoodStatement = $db->prepare($updatefoodQuery);
			$updatefoodStatement->bindParam(':food_id', $food_id, PDO::PARAM_INT);
			$updatefoodStatement->bindParam(':category_id', $category_id, PDO::PARAM_INT);
			$updatefoodStatement->bindParam(':supplier_id', $supplier_id, PDO::PARAM_INT);
			$updatefoodStatement->bindParam(':food_name', $food_name);
			$updatefoodStatement->bindParam(':description', $description);
			$updatefoodStatement->bindParam(':food_price', $food_price);
			$updatefoodStatement->bindParam(':available_quantity', $available_quantity);
			$updatefoodStatement->bindParam(':image_name', $image_name);
			$updatefoodStatement->bindParam(':active', $active);

			if ($updatefoodStatement->execute()) {
				$_SESSION['update'] = "
				<div class='alert alert--success' id='alert'>
					<div class='alert__message'>
						Food Updated Successfully
					</div>
				</div>
			";

				header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
			} else {
				$_SESSION['update'] = "
					<div class='alert alert--danger' id='alert'>
						<div class='alert__message'>	
							Failed to Update Food
						</div>
					</div>
				";

				header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
			}
		}
		ob_end_flush();
		?>
	</div>
</div>