<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=slon",'root','');

} catch (PDOException $e) {
    echo "ошибка";
}
$sql_select = "SELECT * FROM `users` WHERE id = 1";
// вивод масива через  foreach
$res = $conn->query($sql_select);
// $r = $res->fetch(PDO::FETCH_ASSOC);
// print $r['messege'] 

class User {
    public $messege, $id;
    function show(){
        echo $this->messege;
    }
}

$obj = $res->fetchAll(PDO:: FETCH_CLASS,'User');
foreach($obj as $user){
    $user->show();
}

?>