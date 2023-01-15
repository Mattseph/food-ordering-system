<?php
include '../../configuration.php';

if (filter_has_var(INPUT_GET, 'rider_id')) {
    $clean_rider_id = filter_var($_GET['rider_id'], FILTER_SANITIZE_NUMBER_INT);
    $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);

    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS=0");

    $sql = "DELETE FROM delivery_rider WHERE rider_id = '$rider_id'";

    $res = mysqli_query($conn, $sql);

    if ($res) {    //Creating SESSION variable to display message.
        $_SESSION['delete'] = "
            <div class='alert alert--success' id='alert'>
                <div class='alert__message'>
                    Delivery Rider Profile Deleted Successfully
                </div>
            </div>
        ";
        //Redirecting to the manage delivery company page.
        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    } else {
        //Creating SESSION variable to display message.
        $_SESSION['delete'] = "
            <div class='alert alert--danger' id='alert'>
                <div class='alert__message'>	
                    Failed to Delete Delivery Rider Profile
                </div>
            </div>
        ";
        //Redirecting to the manage delivery company page.
        header('location:' . SITEURL . 'admin/delivery_rider_manage/delivery_manage.php');
    }

}
