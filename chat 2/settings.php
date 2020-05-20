<?php
 require_once 'config.php';
 if(!$_SESSION['user']['login']) header("Location: index.php");
 else{
   $templater = new templater();
   $update = new update();
   $templater->showprofile($_SESSION['user']['login']);
   if($_POST){
      $name = strip_tags($_POST['name']);
      $gender = $_POST['gender'];
      $age = strip_tags((int)$_POST['age']);
      $arr = array($name,$gender,$age);
      $update->updateProfile($arr);
   }
   $title = "Редактирование личного кабинета".$_SESSION['user']['login'];
   print $templater->tmp($title,'header.tpl');
   print $templater->tmp($title,'setings.tpl');
   print $templater->tmp($title,'footer.tpl');
 }
?>
