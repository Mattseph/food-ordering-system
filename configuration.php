<?php
session_start();

date_default_timezone_set('Asia/Manila');

define('SITEURL', 'http://localhost/food_system/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'food_ordering');


$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die();
$db_select = mysqli_select_db($conn, DB_NAME) or die();
