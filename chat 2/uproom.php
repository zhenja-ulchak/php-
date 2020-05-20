<?php
 require_once 'config.php';
  if(!$_SESSION['user']['login']) die("Not Found 404");
  $select = new select();
  $templater = new templater();
  $title = "Список активных комнат";
  print $templater->tmp($title,'header.tpl');
  print $select->countRoomTitleandDescription();
  print $templater->tmp($title,'footer.tpl');

?>
