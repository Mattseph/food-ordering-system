<?php
include 'front-partials/header.php';
?>
<!-- Food Search Section Starts Here -->
<div class="landing-container">
    <?php

    if (isset($_SESSION['user'])) {
        echo $_SESSION['user'];
        unset($_SESSION['user']);
    }


    if (isset($_SESSION['contact'])) {
        echo $_SESSION['contact'];
        unset($_SESSION['contact']);
    }

    ?>
    <div class="image-container">
        <div class="images">
            <img src="../images/frontend-bg/landingpage1.jpg">
            <img src="../images/frontend-bg/landingpage2.jpg">
            <img src="../images/frontend-bg/landingpage3.jpg">

        </div>
    </div>
    <div class="heading">
        <h1>Order food</h1>
        <h1>The easy way</h1>
        <div class="header-text">
            <p><span style="color:rgb(255,198,27)">QuickBites</span> is a fast food ordering web app that allows customers to quickly and easily order food from a wide range of popular restaurants. With a few taps on their phone or clicks on their computer, customers can browse menus, select items, and place their order. QuickBites offers fast food delivery, so customers can enjoy their meals at home, at work, or on the go. The web application is easy to use, making ordering fast food more convenient than ever.</p>
        </div>
    </div>

</div>

<!-- Categories Section Starts Here -->
<section class="category-wrapper">
    <section class="category-container" style="margin-bottom: 50px">
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

                    <a href="<?php echo SITEURL; ?>frontend/category-foods.php?category_id=<?php echo $category_id; ?>">
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

<div class="contact">
    <div class="contact-header">
        <h1 style="color:rgb(255,198,27)">Contact Us</h1>
        <p>Let's talk about our website or project. Send us a message and we will be in touch within one business day.</p>
    </div>
    <div class="contact-container">
        <div class="contact-form">
            <form action="" method="POST" enctype="multipart/form-data">

                <?php
                ob_start();
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                    $sql1 = "SELECT * FROM users WHERE user_id = $user_id";

                    $res1 = mysqli_query($conn, $sql1);

                    $count1 = mysqli_num_rows($res1);

                    if ($count1 === 1) {
                        $row1 = mysqli_fetch_assoc($res1);

                        $user_id = $row1['user_id'];
                        $user_lastname = $row1['user_lastname'];
                        $user_firstname = $row1['user_firstname'];
                        $user_email = $row1['user_email'];
                        $user_phonenumber = $row1['user_phonenumber'];
                    }
                }


                ?>
                <div class="contact-wrapper">
                    <section class="contact-input">
                        <div class="placeholder">
                            <input type="text" name="lastname" class="input" id="lastname" pattern="[A-Za-z]+" value="<?php echo $user_lastname ?? ''; ?>" readonly>
                            <label for="lastname">Lastname</label>
                        </div>

                        <div class="placeholder">
                            <input type="text" name="firstname" class="input" id="firstname" pattern="[A-Za-z]+" value="<?php echo $user_firstname ?? ''; ?>" readonly>
                            <label for="firstname">Firstname</label>
                        </div>
                    </section>

                    <section class="contact-input">
                        <div class="placeholder">
                            <input type="email" name="email" id="email" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9 -]+\.[a-z]{2,}" value="<?php echo $user_email ?? ''; ?>" readonly>
                            <label for="email">Email</label>
                        </div>
                    </section>

                    <section class="contact-input">
                        <div class="placeholder">
                            <input type="tel" name="contactnumber" title="Must Be 11-Digit" id="contactnumber" pattern="[0-9+]{5,}" value="<?php echo $user_phonenumber ?? ''; ?>" readonly>
                            <label for="contactnumber">Phone Number</label>
                        </div>
                    </section>

                    <section class="contact-textarea">
                        <div class="placeholder">
                            <textarea type="textarea" name="message" id="sendmessage" pattern="[A-Za-z0-9.+_-@ !#$%?<>()&*^]+" required></textarea>
                            <label for="sendmessage">Message</label>
                        </div>
                    </section>

                    <section class="contact-button">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?? ''; ?>">
                        <button type="submit" name="submit">Send Message</button>
                    </section>

                </div>

            </form>
        </div>

        <div class="contact-links">
            <a href="https://web.facebook.com/matthewfang.bilaos" target="_blank">
                <img src="../images/social-media/facebook.svg" alt="facebook-logo">
            </a>
            <a href="" target="_blank">
                <img src="../images/social-media/instagram.svg" alt="instagram-logo">
            </a>
            <a href="" target="_blank">
                <img src="../images/social-media/twitter.svg" alt="twitter-logo">
            </a>
            <a href="https://github.com/Mattseph" target="_blank">
                <img src="../images/social-media/github-svgrepo-com.svg" alt="github-logo">
            </a>
        </div>

    </div>
</div>

<?php
if (filter_has_var(INPUT_POST, 'submit')) {
    $id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_var($id, FILTER_VALIDATE_INT);
    $message = htmlspecialchars($_POST['message']);
    $date_message = date("Y-m-d H-m-s");

    $sql = "INSERT INTO messages 
        (
            user_id, 
            message,
            date_message
        )
        VALUES
        (
            $user_id,
            '$message',
            '$date_message'
        )";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['contact'] = "<div id='message' class='success contact-message'><img src='../images/logo/successful.svg' alt='successful' class='successful'><span>Message Sent Successfully</nspa></div>";

        header('location:' . SITEURL . 'frontend/index.php');
    } else {
        $_SESSION['contact'] = "<div id='message' class='fail contact-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Message Sent Failed</span></div>";

        header('location:' . SITEURL . 'frontend/index.php');
    }
}
ob_end_flush();
?>
<!--Contact Us Section End-->

</body>

</html>