<?php
include '../../configuration/constants.php';

if (filter_has_var(INPUT_GET, 'rider_id')) {
    $clean_rider_id = filter_var($_GET['rider_id'], FILTER_SANITIZE_NUMBER_INT);
    $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);

    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

    $sql = "DELETE FROM delivery_rider WHERE rider_id = '$rider_id'";

    $res = mysqli_query($conn, $sql);

    if ($res) {    //Creating SESSION variable to display message.
        $_SESSION['delete'] = "<div id='message' class='success delivery-message'><img src='../../images/logo/successful.svg' alt='successful' class='successful'><span>Deleted Successfully</span></div>";
        //Redirecting to the manage delivery company page.
        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    } else {
        //Creating SESSION variable to display message.
        $_SESSION['delete'] = "<div id='message' class='fail delivery-message'><img src='../../images/logo/warning.svg' alt='warning' class='warning'><span>Failed to Delete, Please try again.</span></div>";
        //Redirecting to the manage delivery company page.
        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    }

    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=1");
}
