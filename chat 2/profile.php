<?php
 require_once 'config.php';
 $templater = new templater();
 if(!$_GET) header("Location:".PATH);
 elseif($_GET){
     $user = strip_tags(trim($_GET['user']));
     $templater->showprofile($user);
     $title = "Профиль пользователя {$user}";
     print $templater->tmp($title,'header.tpl');
     print $templater->tmp($title,'profile.tpl');
     print $templater->tmp($title,'footer.tpl');
 }

?>
