<?php

require_once 'config.php';

//     // file_exists - перевіряє чи існує файл
if (!file_exists("db/chat.db")) {
    die("<h1>DATABASE NOT FOUND</h1>" );
}
$templater = new templater();
$validate = new validate();
// if($_SESSION['user']['login']) die("ви уже зарегались");
 if($_POST){
    try {
        if(!$validate->validation($_POST));
    } catch (Exception $e) {
        die($e->__toString());
    }
}
// if($_GET['email']){
//     if(!$select->getAjax($_GET['email']));
//    }


   
 

$title = "регистрация";
print $templater->tmp($title, 'header.tpl');
print $templater->tmp($title, 'reg.tpl');
print $templater->tmp($title, 'footer.tpl');



?>


