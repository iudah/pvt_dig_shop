<?php

$host = "127.0.0.1";
$user = "root";
$pass = "abayomis";
$db = "shop_db";

$option = [PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try {
    $db_conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass, $option);
} catch (Exception $e) {
    exit($e->getMessage());
}
?>
