<?php
  try{
$conn = new PDO("mysql:host=localhost;dbname=ajax",'root','240290');
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$id = 2;
$name = 'stas';
$sql = $conn->prepare("SELECD * FROM ajax1 WHERE id = :id AND name = :name");
$sql->bindParam(':id',$id,PDO::PARAM_INT);
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->execute();
$result = $sql->fetch(PDO::FETCH_ASSOC);

echo $result['ton'];
}catch(PDOException $e){
	echo "Операция невозможна";
	file_put_contents('error.txt',"<hr />".$e->getMessage()."<hr />");
}
//$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
/*echo $conn->errorCode();
print_r($conn->errorInfo());  */




?>
