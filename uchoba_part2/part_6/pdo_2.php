<?php
try{
$conn = new PDO("mysql:host=localhost;dbname=ajax",'root','240290');
}catch(PDOException $e){
	echo "Ошибка конфигурации";
}
/**$sql_select = "SELECT * FROM ajax1 WHERE id =2";

$obj = $res->fetch(PDO::FETCH_OBJ);
print $obj->age;*/   /*
$sql_select = "SELECT * FROM ajax1";
$res = $conn->query($sql_select);
class User{	public $id,$name,$LastName,$age,$ton,$job;
	function show(){		echo $this->name."\n".$this->age."\n".$this->ton."<br />";	}}
$res->setFetchMode(PDO::FETCH_CLASS,'User');
while($nn = $res->fetch()){	echo $nn->age;}
/*foreach($obj as $user){	echo $user->show();} */

$name = "O'Reilly";
$name = $conn->quote($name);
echo $name;


?>

