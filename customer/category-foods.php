<?php include 'customer-partials/header.php'; ?>

<?php
if (isset($_GET['category_id'])) {
    //Get the category_id from categories
    $category_id = $_GET['category_id'];
    //Create a query to display first 3 category
    $categoryQuery = "SELECT category_name from category_list WHERE category_id = :category_id";
    $categoryStatement = $pdo->prepare($categoryQuery);
    $categoryStatement->bindParam(':category_id', $category_id);
    //Run the query
    $categoryStatement->execute();
    //Get the values of each attribute.
    $category = $categoryStatement->fetch(PDO::FETCH_ASSOC);

    $category_name = $category['category_name'];
} else {
    //Category id doesn't match
    //Redirect to category page
    header('location:' . SITEURL . 'customer/categories.php');
}
?>
<section class="food-wrapper">
    <section class="food-container">
        <h2 style="position: absolute; top: 100px;">Food Menu</h2>
        <h3 style="position: absolute; top: 200px;">Food related to <u>"<?php echo $category_name . ' Category'; ?>"</u></h3>
        <section class="food-menu">

            <?php
            $foodQuery = "SELECT * FROM food_list WHERE category_id= :category_id";
            $foodStatement = $pdo->prepare($foodQuery);
            $foodStatement->bindParam(':category_id', $category_id);
            $foodStatement->execute();
            $foodCount = $foodStatement->rowCount();

            if ($foodCount > 0) {
                while ($food = $foodStatement->fetch(PDO::FETCH_ASSOC)) {
                    //Store the value from database to variable
                    $food_id = $food['food_id'];
                    $food_name = $food['food_name'];
                    $description = $food['description'];
                    $food_price = $food['food_price'];
                    $image_name = $food['image_name'];

            ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if ($image_name == "") {
                                echo "<div>Image not available</div>";
                            } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive">
                            <?php
                            }
                            ?>
                        </div>

                        <div class="food-menu-desc">
                            <p class="food-title">Food Name: <span><?php echo $food_name; ?></span></p>
                            <p class="food-price">Price: <span>$<?php echo $food_price; ?></span></p>
                            <p class="food-detail">Description: <span><?php echo $description; ?></span></p>

                            <div class="food-menu-button">
                                <a href="<?php echo SITEURL; ?>customer/order_details.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Here</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div>Food doesn't exist</div>";
            }
            ?>

        </section>
    </section>
</section>
<!-- Food Menu Section Ends Here -->

</body>

</html>