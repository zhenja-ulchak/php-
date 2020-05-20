<?php
// foreach(PDO::getAvailableDrivers() as $res){
//     echo $res."<br />";
// }
// PDO::getAvailableDrivers() показує які є субд на сервері
try {
    $conn = new PDO("mysql:host=localhost;dbname=slon",'root','');

} catch (PDOException $e) {
    echo "ошибка";
}
$sql = "INSERT INTO users(messege) VALUES ('IVAN') ";
$result = $conn->exec($sql) or die('ошибка');
if ($result){
    print "Изменены $result";
}
// запрос до бази
$sql_select = "SELECT messege FROM `users` WHERE id = 1";
// вивод масива через  foreach
foreach ($conn->query($sql_select) as $q){
    // $q ['messege'] указуєм на солбец який ми виводим
    print $q ['messege'];
}





?>