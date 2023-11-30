<?php include('../configuration.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/jpg" href="../images/logo/logo.jpg">
    <title>Sign Up - Quick Bites</title>
</head>

<body>

    <main class="register-container">
        <div class="register-background">
            <img src="../images/signin/signup.png" alt="Sign up Background ">
        </div>


        <br>
        <br>
        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        // $input = [];
        // $error = [];
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="register">

            <div class="register-wrapper">
                <h1 style="margin-bottom: 25px;">Sign Up</h1>

                <section class="register-input">
                    <div class="placeholder">
                        <input type="text" id="lastname" name="lastname" class="input" pattern="[A-Za-z ]+" required autofocus>
                        <label for="lastname">Lastname</label>
                    </div>

                    <div class="placeholder">
                        <input type="text" id="firstname" name="firstname" class="input" pattern="[A-Za-z ]+" required>
                        <label for="firstname">Firstname</label>
                    </div>
                </section>

                <!-- <section class="register-input">
                    <div class="placeholder">
                        <input type="text" name="username" id="username" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{5,}" value="<?php echo $input['username'] ?? ' ' ?>" class="<?php echo isset($error['username']) ? 'error' : ' ' ?>">
                        <label for="username">Username</label>
                    </div>
                    <div><?php echo $error['username'] ?? ' ' ?></div>
                </section> -->

                <section class="register-input">
                    <div class="placeholder">
                        <input type="text" name="username" id="username" title="Please enter correct username" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{5,}" required autofocus>
                        <label for="username">Username</label>
                    </div>
                </section>

                <section class="register-input">
                    <div class="placeholder">
                        <input type="email" name="email" id="email" pattern="[A-Za-z0-9.-_@+]+@[A-Za-z0-9 -]+\.[a-z]{2,}" required>
                        <label for="email">Email</label>
                    </div>
                </section>

                <section class="register-input">
                    <div class="placeholder">
                        <input type="tel" name="contactnumber" title="Must Be 11-Digit" id="phonenumber" pattern="09[0-9]{9}" title="09XXXXXXXXX" maxLength="11" required>
                        <label for="phonenumber">Phone Number</label>
                    </div>
                </section>

                <section class="register-input">
                    <div class="placeholder">
                        <input type="password" name="password1" id="password" title="At least 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]]{8,}" required>
                        <label for="password">Password</label>
                    </div>
                </section>

                <section class="register-input">
                    <div class="placeholder">
                        <input type="password" name="password2" id="password2" title="At least 8 characters" pattern="[A-Za-z0-9!@#$%^&*()_+=-?/ ]{8,}" required>
                        <label for="password2">Confirm Your Password</label>
                    </div>
                </section>

                <section class="register-button">
                    <div>
                        <button type="submit" name="submit" class="btn">Sign up</button>
                    </div>
                </section>
            </div>
        </form>
    </main>

    <?php
    // const username_error = "Please Enter Your Email";
    // $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    // $input['username'] = $username;

    // if ($username) {
    //     $username = trim($username);
    //     if ($username === ' ') {
    //         $error['username'] = username_error;
    //     }
    // }

    if (filter_has_var(INPUT_POST, 'submit')) {
        $lastname = htmlspecialchars(ucwords($_POST['lastname']));
        $firstname = htmlspecialchars(ucwords($_POST['firstname']));
        $username = htmlspecialchars($_POST['username']);

        $clean_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = filter_var($clean_email, FILTER_VALIDATE_EMAIL);

        $contactno = htmlspecialchars($_POST['contactnumber']);

        $password1 = htmlspecialchars(md5($_POST['password1']));
        $password2 = htmlspecialchars(md5($_POST['password2']));

        $role = htmlspecialchars('Customer');

        if ($password1 === $password2) {
            $sql = "INSERT INTO users 
                (
                    user_lastname, 
                    user_firstname, 
                    user_username, 
                    user_password, 
                    user_email, 
                    user_phonenumber,
                    user_role
                ) 
                VALUES 
                (
                    :lastname,
                    :firstname,
                    :username,
                    :user_password,
                    :email,
                    :contactno,
                    :role
                )";

            $statement = $pdo->prepare($sql);
            $statement->bindParam(':lastname', $lastname);
            $statement->bindParam(':firstname', $firstname);
            $statement->bindParam(':username', $username);
            $statement->bindParam(':user_password', $password1);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':contactno', $contactno);
            $statement->bindParam(':role', $role);


            if ($statement->execute()) {
                $_SESSION['add'] = "
                    <div class='alert alert--success' id='alert'>
                        <div class='alert__message'>
                            Registered Successfully
                        </div>
                    </div>
                ";
                header('location:' . SITEURL . 'customer/signin.php');
            } else {
                $_SESSION['add'] = "
                    <div class='alert alert--danger' id='alert'>
                        <div class='alert__message'>	
                            Failed to Register
                        </div>
			        </div>
                ";
                header('location:' . SITEURL . 'customer/signup.php');
            }
        } else {
            $_SESSION['add'] = "
                <div class='alert alert--danger' id='alert'>
                    <div class='alert__message'>	
                        Password Did Not Match
                    </div>
                </div>
            ";
            header('location:' . SITEURL . 'customer/signup.php');
        }
    }
    ?>
</body>

</html>