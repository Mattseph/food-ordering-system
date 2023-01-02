<?php
include '../configuration/constants.php';
unset($_SESSION['user']);
session_destroy();

header('location:' . SITEURL . 'frontend/signin.php');
