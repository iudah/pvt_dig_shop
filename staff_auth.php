<?php

include_once("common/root.php");
include_once("common/classes.php");


$id = $_POST["id"] ?? null;
$password = $_POST["password"] ?? null;

if (!$id || !$password) {
    echo("Id or password is null");
}

$stmt = $db_conn->prepare("select name, job, id from staff where id=? and password=?;");
$stmt->execute([$id, $password]);
$staff = $stmt->fetchAll(PDO::FETCH_CLASS, 'Staff');
if (count($staff) != 1) {
    echo("user not found");
    header("Location: index.html");
}

session_start();
$_SESSION['staff'] = $staff[0];
if ($staff[0]->job === "manager") {
    header("Location: dash/manager_dash.php");
} else {
    header("Location: dash/cashier_dash.php");
}

exit();
?>