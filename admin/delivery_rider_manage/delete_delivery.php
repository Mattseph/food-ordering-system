<?php
session_start();
include '../../configuration.php';

if (filter_has_var(INPUT_GET, 'rider_id')) {
    $clean_rider_id = filter_var($_GET['rider_id'], FILTER_SANITIZE_NUMBER_INT);
    $rider_id = filter_var($clean_rider_id, FILTER_VALIDATE_INT);

    $foreignQuery = "SET FOREIGN_KEY_CHECKS=0";
    $pdo->query($foreignQuery);

    $deleteriderQuery = "DELETE FROM delivery_rider WHERE rider_id = :rider_id";
    $deleteridertatement = $pdo->prepare($deleteriderQuery);
    $deleteridertatement->bindParam(':rider_id', $rider_id, PDO::PARAM_INT);

    if ($deleteridertatement->execute()) {    //Creating SESSION variable to display message.
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
