<?php
include_once("../common/root.php");
include_once("../common/classes.php");

$new_name=$_POST['new_name']??null;
$old_name=$_POST['old_name']??null;
$id=$_POST['id']??null;

try{
$stmt=$db_conn->prepare("update staff set name=? where name=? and id=?;");
$stmt->execute([htmlspecialchars_decode($new_name),htmlspecialchars_decode($old_name),htmlspecialchars_decode($id)]);


}catch(Exception $err){
    echo(json_encode(["successful"=>false,"msg"=>$err->getMessage()]));
    exit();
}

echo(json_encode(["successful"=>true]));
?>

