<?php
 require_once '../config.php';
 $select = new select();
 $templater = new templater();
 if($_SESSION['user']['login'] != $select->adminToIdOne()) die('Error Not Found 404');
 
 $title = "Управление комнатами чата";
 print $templater->tmp($title,'header.tpl');
 print $select->otherRoom();
 print $templater->tmp($title,'footer.tpl');
?>
