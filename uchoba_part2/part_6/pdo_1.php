<?php
 /*foreach(PDO::getAvailableDrivers() as $res){ 	echo $res."<br />"; }   */
try{
$conn = new PDO("mysql:host=localhost;dbname=ajax",'root','240290');
}catch(PDOException $e){	echo "������ ������������";}
/*$sql = "INSERT INTO ajax1(name,LastName,age,ton,job) VALUES('Ivan','Ivanov','25','Chicago','Programming')";
$result = $conn->exec($sql) or die('������');
if($result) print "�������� $result ������";  */

$sql_select = "SELECT ton FROM ajax1";
foreach ($conn->query($sql_select) as $arr){	echo $arr['ton']."<br />";}






?>
