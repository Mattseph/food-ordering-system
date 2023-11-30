
<?php
date_default_timezone_set('Asia/Manila');

define('SITEURL', 'http://localhost/FoodSystem/');
$localhost = 'localhost:3308';
$db_name = 'food_ordering';
$username = 'root';
$password = 'Bilaosrrmmmjg02311';


$dsn = "mysql:host=$localhost;dbname=$db_name;charset=UTF8;";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}
