<?php
include_once("../common/root.php");
include_once("../common/classes.php");

$name=$_POST['name']??null;
$desc=$_POST['desc']??null;
$price=$_POST['price']??null;
$qty=$_POST['qty']??null;


try{$stmt=$db_conn->prepare("insert into product(name, description, price,available_quantity) values (?,?,?,?);");
$stmt->execute([htmlspecialchars_decode($name),htmlspecialchars_decode($desc), htmlspecialchars_decode($price), htmlspecialchars_decode($qty)]);

$stmt = $db_conn->prepare("select id, name from product where name=?;");
$stmt->execute([htmlspecialchars_decode($name)]);
$staff = $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');

if(count($staff)!==1)
echo(json_encode(["msg"=>"An error occured while adding item.","successful"=>false]));

}catch(Exception $err){
    echo(json_encode(["msg"=>$err->getMessage(),"successful"=>false]));
}

echo(json_encode(["id"=>$staff[0]->id, "name"=>$name,"successful"=>true]));

exit();
?>
