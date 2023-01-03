<?php include 'front-partials/header.php'; ?>

<?php
if (isset($_GET['category_id'])) {
    //Get the category_id from categories
    $category_id = $_GET['category_id'];
    //Create a query to display first 3 category
    $sql = "SELECT category_name from category_list WHERE category_id = $category_id";
    //Run the query
    $res = mysqli_query($conn, $sql);
    //Get the values of each attribute.
    $row = mysqli_fetch_assoc($res);

    $category_name = $row['category_name'];
} else {
    //Category id doesn't match
    //Redirect to category page
    header('location:' . SITEURL . 'frontend/categories.php');
}
?>
<section class="food-wrapper">
    <section class="food-container">
        <h2 style="position: absolute; top: 100px;">Food Menu</h2>
        <h3 style="position: absolute; top: 200px;">Food related to <u>"<?php echo $category_name . ' Category'; ?>"</u></h3>
        <section class="food-menu">

            <?php
            $sql2 = "SELECT * FROM food_list WHERE category_id=$category_id";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if ($count2 > 0) {
                while ($row2 = mysqli_fetch_array($res2)) {
                    //Store the value from database to variable
                    $food_id = $row2['food_id'];
                    $food_name = $row2['food_name'];
                    $description = $row2['description'];
                    $food_price = $row2['food_price'];
                    $image_name = $row2['image_name'];

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
                                <a href="<?php echo SITEURL; ?>frontend/order_details.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Here</a>
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