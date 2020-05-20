<?php
require_once '../config.php';
$templater = new templater();
$select = new select();
if($_POST){
  $login = strip_tags(trim($_POST['admin_login']));
  $password = trim($_POST['admin_password']);
  if($select->getAdmin($login,$password)){
      $_SESSION['user']['login'] = $login;
  }
}
if($_SESSION['user']['login'] == $select->adminToIdOne()){
    $title = "Админка";
    print $templater->tmp($title,'header.tpl');
    print $templater->tmp($title,'admin.tpl');
    print $templater->tmp($title,'footer.tpl');
}else{
   $title = "Вход в админку"; 
   print $templater->tmp($title,'header.tpl');
    print $templater->tmp($title,'admin_auth.tpl');
    print $templater->tmp($title,'footer.tpl');
}
?>
