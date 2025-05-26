<?php
include_once("../common/root.php");
include_once("../common/classes.php");

$id=$_POST['id']??null;

try{
$stmt=$db_conn->prepare("delete from staff where id=?;");
$stmt->execute([htmlspecialchars_decode($id)]);
}catch(Exception $err){
    echo(json_encode(["successful"=>false,"msg"=>$err->getMessage()]));
    exit();
}

echo(json_encode(["successful"=>true]));
?>
