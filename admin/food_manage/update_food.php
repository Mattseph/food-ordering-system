<?php
ob_start();
include '../partials/head.php';

if (filter_has_var(INPUT_GET, 'food_id')) {
	$clean_id = filter_var($_GET['food_id'], FILTER_SANITIZE_NUMBER_INT);
	$food_id = filter_var($clean_id, FILTER_VALIDATE_INT);
	$sql2 = "SELECT * FROM food_list WHERE food_id = '$food_id'";

	$res2 = mysqli_query($conn, $sql2);

	$count2 = mysqli_num_rows($res2);
	if ($count2 === 1) {
		$row2 = mysqli_fetch_assoc($res2);

		$current_category = $row2['category_id'];
		$current_supplier = $row2['supplier_id'];
		$food_name = $row2['food_name'];
		$description = $row2['description'];
		$price = $row2['food_price'];
		$available_quantity = $row2['available_quantity'];
		$current_image = $row2['image_name'];
		$active = $row2['active'];
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
			</div>

			<div class="form-group">
				<div class="placeholder">
					<select name="category" required>
						<?php
						$sql = "SELECT * FROM category_list WHERE active = 'Yes'";
						$res = mysqli_query($conn, $sql);
						$count = mysqli_num_rows($res);

						if ($count > 0) {
							while ($row = mysqli_fetch_assoc($res)) {
								$category_id = $row['category_id'];
								$category_name = $row['category_name'];

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
						$sql4 = "SELECT * FROM suppliers WHERE active='YES'";
						$res4 = mysqli_query($conn, $sql4);
						$count4 = mysqli_num_rows($res4);

						if ($count4 > 0) {
							while ($row4 = mysqli_fetch_assoc($res4)) {
								$supplier_id = $row4['supplier_id'];
								$supplier_lastname = $row4['supplier_lastname'];
								$supplier_firstname = $row4['supplier_firstname'];

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
			$desc = htmlspecialchars($_POST['description']);

			$food_price = htmlspecialchars($_POST['price']);
			$available_quantity = htmlspecialchars($_POST['available_quantity']);

			$current_image = htmlspecialchars($_POST['current_image']);
			$active = htmlspecialchars($_POST['active']);


			if (isset($_FILES['image']['name'])) {
				$image_name = $_FILES['image']['name'];

				if ($image_name != "") {
					$image_name_parts = explode('.', $image_name);
					$ext = end($image_name_parts);
					$image_name = "Food_Name_" . rand(000, 999) . '.' . $ext;
					$source_path = $_FILES['image']['tmp_name'];
					$destination_path = "../../images/food/" . $image_name;
					$upload = move_uploaded_file($source_path, $destination_path);

					if ($upload == false) {
						$_SESSION['upload_photo_failed'] = "
							<div class='alert alert--danger' id='alert'>
								<div class='alert__message'>	
									Failed to Upload Photo
								</div>
							</div>
						";

						header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
						die();
					}
					if ($current_image != "") {
						$remove_path = "../../images/food/" . $current_image;

						$remove = unlink($remove_path);

						if ($remove == false) {
							$_SEESION['remove_photo_failed'] = "
								<div class='alert alert--danger' id='alert'>
									<div class='alert__message'>	
										Failed to Remove Current Image
									</div>
								</div>
							";

							header('location:' . SITEURL . 'admin/food_manage/food_manage.php');
							die();
						}
					}
				} else {
					$image_name = $current_image;
				}
			} else {
				$image_name = $current_image;
			}

			$sql3 = "UPDATE food_list SET
				category_id = $category_id,
				supplier_id = $supplier_id,
				food_name = '$food_name',
				description = '$desc',
				food_price = '$food_price',
				available_quantity = '$available_quantity',
				image_name = '$image_name',
				active = '$active'
				WHERE food_id = $food_id
			";

			$res3 = mysqli_query($conn, $sql3);

			if ($res3) {
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