<?php
include_once("../common/root.php");
include_once("../common/classes.php");


$id=$_POST['id']??null;
$name=$_POST['name']??null;
$desc=$_POST['desc']??null;
$price=$_POST['price']??null;
$qty=$_POST['qty']??null;


try{
$stmt=$db_conn->prepare("update product set name=?,description=?,price=?,available_quantity=?  where id=?;");
$stmt->execute([htmlspecialchars_decode($name),htmlspecialchars_decode($desc),htmlspecialchars_decode($price), htmlspecialchars_decode($qty), htmlspecialchars_decode($id)]);


}catch(Exception $err){
    echo(json_encode(["successful"=>false,"msg"=>$err->getMessage()]));
    exit();
}

echo(json_encode(["successful"=>true]));
?>

