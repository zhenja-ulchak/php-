<?php
 require_once 'config.php';
 if($_POST){
     $select = new select();
     $email = strip_tags($_POST['email']);
     $password = md5($_POST['password']);
     if(!$select->avto($email,$password));

     header("Location: index.php");
 }
 if($_SESSION['user']['login']) die("Вы уже авторизированны");
 if(!file_exists("db/chat.db"))
      die("<h1>DATABASE NOT FOUND</h1>");
 $templater = new templater();
 $validate = new validate();

 $title = "Авторизация";
 print $templater->tmp($title,'header.tpl');
 print $templater->tmp($title,'avto.tpl');
 print $templater->tmp($title,'footer.tpl');
?>