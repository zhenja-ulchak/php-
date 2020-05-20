<?php
 require_once 'config.php';
 $select = new select();
 if($_GET['logout'] == true){
     unset($_SESSION['user']['login']);
     header('Location: index.php');
  }
  if($_GET['email']){
   if(!$select->getAjax($_GET['email']));
  }
 $templater = new templater();
 $title = "Главная";
 print $templater->tmp($title,'header.tpl');
 if(!$_SESSION['user']['login']){
   include_once 'temp/home.php';
 }else{
   print $templater->tmp($title,'home.tpl');
 }
 print $templater->tmp($title,'footer.tpl');

 ?>