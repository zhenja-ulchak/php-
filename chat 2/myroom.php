<?php
   require_once 'config.php';
   if(!$_SESSION['user']['login']) die("Not Found 404");
   $templater = new templater();
   $select = new select();
   $insert = new insert();
   $userid = $select->LoginToId($_SESSION['user']['login']);
   if($_POST){
       $title = strip_tags($_POST['title']);
       $description = strip_tags($_POST['message']);
       $uid = (int)$userid;
       if($title == "" && $description == "") die("Поля не заполнены");
       if(!$insert->newTheme($uid,$title,$description)) return;
       else print("Данные успешно добавлены");
           
     }
    $title = "Создание новой комнаты";
    print $templater->tmp($title,'header.tpl');
    print $templater->tmp($title,'newroom.tpl');
    print $templater->tmp($title,'footer.tpl');

?>
