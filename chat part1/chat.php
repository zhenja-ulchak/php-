<?php
require_once 'config.php';
if(!$_SESSION['user']['login']) die("Not Found 404");

$templater = new templater();
$insert = new insert();
$title = "чат";
if(!$_GET) die("комната не выбрана");
$id = (int)$_GET['roomid'];
$_SESSION['id_room'] = $id;
include_once 'newroom.php';
        
?>
