<?php
 require_once 'config.php';
 $templater = new templater();
 if(!$_GET){
 header("Location:".PATH);
 exit();
 }
 elseif($_GET){
    //  убераэм вси знаки 
     $user = strip_tags(trim($_GET['user']));
     $templater->showprofile($user);
     $title = "Профіль пользователя {$user}";
     print $templater->tmp($title,'header.tpl');
     print $templater->tmp($title,'profile.tpl');
     print $templater->tmp($title,'footer.tpl');
 }

?>
