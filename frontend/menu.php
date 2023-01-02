<?php include 'front-partials/header.php'; ?>

<!-- Food Menu Section Starts Here -->
<section class="food-wrapper">
    <section class="food-container">
        <h2 style="position: absolute; top: 100px;">Food Menu</h2>

        <section class="food-menu">

            <?php
            //Display food that's active.
            $sql = "SELECT * FROM food_list WHERE active = 'Yes'";
            //Execute the query above.
            $res = mysqli_query($conn, $sql);
            //Number of rows in the result set.
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                //Get the Food Available in Database.
                while ($row = mysqli_fetch_assoc($res)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $description = $row['description'];
                    $food_price = $row['food_price'];
                    $image_name = $row['image_name'];
            ?>
                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if ($image_name == "") {
                                echo "<div> No image</div>";
                            } else {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pepperoni Pizza" class="img-responsive">
                            <?php

                            }

                            ?>

                        </div>

                        <div class="food-menu-desc">
                            <p class="food-title">Food Name: <span><?php echo $food_name; ?></span></p>
                            <p class="food-price">Price: <span>$<?php echo $food_price; ?></span></p>
                            <p class="food-detail">Description: <span><?php echo $description; ?></span></p>
                            <div class="food-menu-button">
                                <a href="<?php echo SITEURL; ?>frontend/order_details.php?food_id=<?php echo $food_id; ?>" class="btn">Order Here</a>
                            </div>
                        </div>
                    </div>

            <?php

                }
            } else {
                echo "<div>Food Not Found</div>";
            }

            ?>


        </section>
    </section>
</section>
<!-- Food Menu Section Ends Here -->

</body>

</html>