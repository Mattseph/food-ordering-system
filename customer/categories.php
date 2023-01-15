<?php include 'customer-partials/header.php'; ?>

<!-- Categories Section Starts Here -->
<section class="category-wrapper">
    <section class="category-container" style="margin-top: 30px">
        <h2>Food Categories</h2>
        <section class="category-menu">
            <?php
            $sql = "SELECT * FROM category_list WHERE active = 'Yes' LIMIT 3";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $category_id = $row['category_id'];
                    $category_name = $row['category_name'];
                    $image_name = $row['image_name'];
            ?>

                    <a href="<?php echo SITEURL; ?>customer/category-foods.php?category_id=<?php echo $category_id; ?>">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='fail'>Image not available</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name ?>" alt="category" class="img-responsive">

                        <?php
                        }
                        ?>


                        <h3 class="text"><?php echo $category_name; ?></h3>
                    </a>

            <?php

                }
            } else {
                echo "<div class='fail'>Category Not Found</div>";
            }
            ?>

        </section>
    </section>
</section>
<!-- Categories Section Ends Here -->

</body>

</html>