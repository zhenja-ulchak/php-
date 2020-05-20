<?php
 require_once '../config.php';
 $select = new select();
 $templater = new templater();
 $delete = new delete();
 if($_SESSION['user']['login'] != $select->adminToIdOne()) die('Error Not Found 404');
 if($_GET){
     $id = (int)$_GET['users_id'];
     $delete->deleteusers($id);
 }
 $title = "”правление юзерами чата";
 print $templater->tmp($title,'header.tpl');
 print $select->otherUsers();
 print $templater->tmp($title,'footer.tpl');
?>
