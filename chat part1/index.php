<?php

require_once 'config.php';

$select = new select();
if ($_GET['logout'] == true) {
    unset($_SESSION['user']['login']);
//     header('Location: reg.php');
//    exit();
die("ви вийшли з админки");
}
if($_GET['email']){
    if(!$select->getAjax($_GET['email']));
   }

//     // file_exists - перевіряє чи існує файл
// if (!file_exists("db/chat.db")) {
//     die("<h1>DATABASE NOT FOUND</h1>" );
// }
$templater = new templater();
$title = "главная";
// вивод
print $templater->tmp($title, 'header.tpl');

if (!$_SESSION['user']['login']) {
    // die("index.php не робить");
    print $templater->tmp($title, 'avto.tpl');
}
// вивод
print $templater->tmp($title, 'footer.tpl');

?>
