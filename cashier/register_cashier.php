<?php
include_once("../common/root.php");
include_once("../common/classes.php");

$name=$_POST['name']??null;
$password=$_POST['password']??null;

try{$stmt=$db_conn->prepare("insert into staff(name, password, job) values (?,?, 'cashier');");
$stmt->execute([htmlspecialchars_decode($name),htmlspecialchars_decode($password)]);

$stmt = $db_conn->prepare("select name, job, id from staff where name=?;");
$stmt->execute([htmlspecialchars_decode($name)]);
$staff = $stmt->fetchAll(PDO::FETCH_CLASS, 'Staff');

if(count($staff)!==1)
echo(json_encode(["msg"=>"An error occured while registering staff.","successful"=>false]));

}catch(Exception $err){    echo(json_encode(["successful"=>false,"msg"=>$err->getMessage()]));
}
echo(json_encode(["id"=>$staff[0]->id, "name"=>$name,"successful"=>true]));

exit();
?>
