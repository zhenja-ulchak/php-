<?php
try{
$conn = new PDO("mysql:host=localhost;dbname=ajax",'root','240290');
}catch(PDOException $e){
	echo "������ ������������";
}
/**$sql_select = "SELECT * FROM ajax1 WHERE id =2";

$obj = $res->fetch(PDO::FETCH_OBJ);
print $obj->age;*/   /*
$sql_select = "SELECT * FROM ajax1";
$res = $conn->query($sql_select);
class User{
	function show(){
$res->setFetchMode(PDO::FETCH_CLASS,'User');
while($nn = $res->fetch()){
/*foreach($obj as $user){

$name = "O'Reilly";
$name = $conn->quote($name);
echo $name;


?>
