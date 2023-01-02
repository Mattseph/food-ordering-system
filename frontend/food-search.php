<?php include 'front-partials/header.php'; ?>

<!-- Food Menu Section Starts Here -->
<section class="food-wrapper">
    <section class="food-container">
        <h2 style="position: absolute; top: 100px;">Food Menu</h2>
        <?php
        //Get the searched keyword
        if (filter_has_var(INPUT_GET, 'search')) {
            $search = filter_var($_GET['search'], FILTER_SANITIZE_SPECIAL_CHARS);
        }


        ?>
        <h3 style="position: absolute; top: 200px;">Food related to <u>"<?php echo $search ?>"</u></h3>
        <section class="food-menu">
            <?php

            $sql = "SELECT * FROM food_list WHERE food_name LIKE '%$search%' OR description LIKE '%$search%'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
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
                                <a href="<?php echo SITEURL; ?>frontend/order_details.php?food_id=<?php echo $food_id; ?>" class="btn btn-primary">Order Here</a>
                            </div>
                        </div>
                    </div>


            <?php
                }
            } else {
                echo "<div><h3>No related food</h3></div>";
            }
            ?>

        </section>
    </section>
</section>

<!-- Food Menu Section Ends Here -->

</body>

</html>