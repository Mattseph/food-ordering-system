<?php
ob_start();
include 'customer-partials/header.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $userQuery = "SELECT * FROM users WHERE user_id = :user_id";
    $userStatement = $pdo->prepare($userQuery);
    $userStatement->bindParam(':user_id', $user_id);
    $userStatement->execute();

    $userCount = $userStatement->rowCount();

    if ($userCount === 1) {
        $user = $userStatement->fetch(PDO::FETCH_ASSOC);

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
                                                                                                                                                                echo "required autofocus";
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
                            <textarea type="textarea" name="message" id="sendmessage" pattern="[A-Za-z0-9.+_-@!#$%?<>()&*^ ]+" <?php if (isset($user_id)) {
                                                                                                                                    echo "required autofocus";
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
    if (isset($_SESSION['user_id'])) {

        $clean_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $user_id = filter_var($clean_id, FILTER_VALIDATE_INT);
        $message = htmlspecialchars($_POST['message']);
        $date_message = date("Y-m-d H-m-s");

        $messageQuery = "INSERT INTO messages 
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

        $messageStatement = $pdo->prepare($messageQuery);
        $messageStatement->bindParam(':user_id', $user_id);
        $messageStatement->bindParam(':message', $message);
        $messageStatement->bindParam(':date_message', $date_message);

        if ($messageStatement->execute()) {
            $_SESSION['contact'] = "<div id='message' class='success contact-message'><img src='images/logo/successful.svg' alt='successful' class='successful'><span>Message Sent Successfully</span></div>";

            header('location:' . SITEURL);
        } else {
            $_SESSION['contact'] = "<div id='message' class='fail contact-message'><img src='images/logo/warning.svg' alt='warning' class='warning'><span>Message Sent Failed</span></div>";

            header('location:' . SITEURL);
        }
    } else {
        $_SESSION['signin-required'] = "<div id='message' class='fail contact-message'><img src='../images/logo/warning.svg' alt='warning' class='warning'><span>Sign in Required</span></div>";
        header('location:' . SITEURL . 'customer/signin.php');
    }
}
ob_end_flush();
?>
</body>

</html>