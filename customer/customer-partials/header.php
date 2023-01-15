<?php
include '../configuration.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Bites</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/jpg" href="../images/logo/logo.jpg">
    <script src="../js/timer.js" type="text/javascript"></script>
</head>

<body>
    <nav>
        <div class="navigation">
            <div class="logo">
                <img src="../images/logo/logo.jpg" alt="Restaurant Logo"> <span class="food-title-first">Food <span class="food-title-second">Ordering</span></span>
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
                    if (isset($_SESSION['user_id'])) {
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