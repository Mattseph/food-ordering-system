<?php
session_start();
include 'configuration.php';
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Bites</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" type="image/png" href="images/logo/logo.png">
    <script src="js/timer.js" type="text/javascript"></script>
</head>

<body>
    <nav>
        <div class="navigation">
            <div class="logo">
                <img src="images/logo/logo.jpg" alt="Restaurant Logo"> <span class="food-title-first">Food <span class="food-title-second">Ordering</span></span>
            </div>

            <div class="middle">
                <ul class="nav-bar">
                    <li>
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>

                    <li>
                        <a href="<?php echo SITEURL; ?>customer/categories.php">Category</a>
                    </li>

                    <li>
                        <a href="<?php echo SITEURL; ?>customer/menu.php">Menu</a>
                    </li>

                    <li>
                        <a href="<?php echo SITEURL; ?>customer/contact.php">Contact Us</a>
                    </li>
                    <?php
                    if (isset($user_id)) {
                    ?>
                        <li><a href="<?php echo SITEURL; ?>customer/logout.php">Log out</a></li>
                    <?php
                    } else {
                    ?>
                        <li><a href="<?php echo SITEURL; ?>customer/signin.php">Sign in</a></li>
                        <li>/</li>
                        <li><a href="<?php echo SITEURL; ?>customer/signup.php">Sign Up</a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>


            <div class="search">
                <?php
                $filter_input = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
                ?>
                <form action="<?php echo SITEURL; ?>customer/food-search.php" method="GET" enctype="multipart/form-data">
                    <input type="search" name="search" placeholder="Search For Food.." value="<?php echo $filter_input; ?>" required>
                    <input type="submit" name="submit" value="Search" class="btn btn-primary">

                </form>
            </div>
        </div>
    </nav>
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
                <img loading="lazy" src="images/customer-bg/landingpage1.jpg">
                <img loading="lazy" src="images/customer-bg/landingpage2.jpg">
                <img loading="lazy" src="images/customer-bg/landingpage3.jpg">

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
                $active = 'Yes';
                $sql = "SELECT * FROM category_list WHERE active = :active LIMIT 3";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':active', $active);
                $statement->execute();
                $count = $statement->rowCount();

                if ($count > 0) {
                    while ($category = $statement->fetch(PDO::FETCH_ASSOC)) {
                        $category_id = $category['category_id'];
                        $category_name = $category['category_name'];
                        $image_name = $category['image_name'];
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

    <!-- Food Menu Section Starts Here -->
    <section class="food-wrapper">
        <section class="food-container">
            <h2 style="position: absolute; top: 100px;">Food Menu</h2>

            <section class="food-menu">

                <?php
                $active = "Yes";
                //Display food that's active.
                $sql = "SELECT * FROM food_list WHERE active = :active";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(':active', $active);
                //Execute the query above.
                $statement->execute();
                //Number of rows in the result set.
                $count = $statement->rowCount();

                if ($count > 0) {
                    //Get the Food Available in Database.
                    while ($food = $statement->fetch(PDO::FETCH_ASSOC)) {
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
                                    <a href="<?php echo SITEURL; ?>customer/order_details.php?food_id=<?php echo $food_id; ?>" class="btn">Order Here</a>
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

    <?php


    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $sql1 = "SELECT * FROM users WHERE user_id = :user_id";
        $statement = $pdo->prepare($sql1);
        $statement->bindParam('user_id', $user_id);
        $statement->execute();
        $count1 = $statement->rowCount();

        if ($count1 === 1) {
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);

            $user_id = $user['user_id'];
            $user_lastname = $user['user_lastname'];
            $user_firstname = $user['user_firstname'];
            $user_email = $user['user_email'];
            $user_phonenumber = $user['user_phonenumber'];
        }
    }
    ?>
    <div class="contact">
        <div class="contact-header">
            <h1 style="color:rgb(255,198,27)">Contact Us</h1>
            <p>Let's talk about our website or project. Send us a message and we will be in touch within one business day.</p>
        </div>
        <div class="contact-container">
            <div class="contact-form">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="contact-wrapper">
                        <section class="contact-input">
                            <div class="placeholder">
                                <input type="text" name="lastname" class="input" id="lastname" pattern="[A-Za-z]+" value="<?php echo $user_lastname ?? ''; ?>" <?php if (isset($_SESSION['user_id'])) {
                                                                                                                                                                    echo "readonly";
                                                                                                                                                                } else {
                                                                                                                                                                    echo "required";
                                                                                                                                                                } ?>>
                                <label for="lastname">Lastname</label>
                            </div>

                            <div class="placeholder">
                                <input type="text" name="firstname" class="input" id="firstname" pattern="[A-Za-z]+" value="<?php echo $user_firstname ?? ''; ?>" <?php if (isset($_SESSION['user_id'])) {
                                                                                                                                                                        echo "readonly";
                                                                                                                                                                    } else {
                                                                                                                                                                        echo "required";
                                                                                                                                                                    } ?>>
                                <label for="firstname">Firstname</label>
                            </div>
                        </section>

                        <section class="contact-input">
                            <div class="placeholder">
                                <input type="email" name="email" id="email" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9 -]+\.[a-z]{2,}" value="<?php echo $user_email ?? ''; ?>" <?php if (isset($_SESSION['user_id'])) {
                                                                                                                                                                                echo "readonly";
                                                                                                                                                                            } else {
                                                                                                                                                                                echo "required";
                                                                                                                                                                            } ?>>
                                <label for="email">Email</label>
                            </div>
                        </section>

                        <section class="contact-input">
                            <div class="placeholder">
                                <input type="tel" name="contactnumber" title="Must Be 11-Digit" id="contactnumber" pattern="[0-9+]{5,}" value="<?php echo $user_phonenumber ?? ''; ?>" <?php if (isset($_SESSION['user_id'])) {
                                                                                                                                                                                            echo "readonly";
                                                                                                                                                                                        } else {
                                                                                                                                                                                            echo "required";
                                                                                                                                                                                        } ?>>
                                <label for="contactnumber">Phone Number</label>
                            </div>
                        </section>

                        <section class="contact-textarea">
                            <div class="placeholder">
                                <textarea type="textarea" name="message" id="sendmessage" pattern="[A-Za-z0-9.+_-@!#$%?<>()&*^ ]+" <?php if (isset($_SESSION['user_id'])) {
                                                                                                                                        echo "required";
                                                                                                                                    } else {
                                                                                                                                        echo "placeholder='Sign in to Contact Us'";
                                                                                                                                    } ?>></textarea>
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
                    <img src="images/social-media/facebook.svg" alt="facebook-logo">
                </a>
                <a href="" target="_blank">
                    <img src="images/social-media/instagram.svg" alt="instagram-logo">
                </a>
                <a href="" target="_blank">
                    <img src="images/social-media/twitter.svg" alt="twitter-logo">
                </a>
                <a href="https://github.com/Mattseph" target="_blank">
                    <img src="images/social-media/github-svgrepo-com.svg" alt="github-logo">
                </a>
            </div>

        </div>
    </div>

    <?php
    if (filter_has_var(INPUT_POST, 'user_id')) {
        $id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $user_id = filter_var($id, FILTER_VALIDATE_INT);
        $message = htmlspecialchars($_POST['message']);
        $date_message = date("Y-m-d H-i-s");

        $sql = "INSERT INTO messages 
            (
                user_id, 
                message,
                date_message
            )
            VALUES
            (
                :user_id,
                :message,
                :date_message
            )";
        $statement = $pdo->prepare($sql);

        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->bindParam(':message', $message);
        $statement->bindParam(':date_message', $date_message);

        if ($statement->execute()) {
            $_SESSION['contact'] = "
            <div class='alert alert--success' id='alert'>
                <div class='alert__message'>
                    Message Sent Successfully
                </div>
		    </div>
            ";

            header('location:' . SITEURL);
        } else {
            $_SESSION['contact'] = "
            <div class='alert alert--danger' id='alert'>
                <div class='alert__message'>	
                    Failed to Sent Message
                </div>
            </div>
            ";
            header('location:' . SITEURL);
        }
    } else {
        $_SESSION['signin-required'] = "
            <div class='alert alert--danger' id='alert'>
				<div class='alert__message'>	
					Sign in Required
				</div>
			</div>
        ";
        header('location:' . SITEURL . 'customer/signin.php');
    }

    ?>
    <!--Contact Us Section End-->
</body>

</html>