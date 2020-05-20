<?php
header('Content-type:text/html; charset=utf-8');
header("Expires:", date("r"));
header('last-Modified:'.gmdate('D, d M Y H:i:s')."GMT");
header('Cache-Control:no-store,no-cache,must-revalidate');

require_once 'install.php';
$result = "";
// єсли чат установлений то діе (готово)
if (file_exists("../db/chat.db")) die("чат уже установен");
// ловим значеня через пост и обробляєм
if ($_POST) {
    // удаля пробели и текст а  (strip_tags html i php теги)
    $login = trim(strip_tags($_POST['login']));
    // кеш пароля
    $password = md5($_POST['password']);
    try {
        // робим исключениє 
        if($login == "") throw new Exception('ви не вели логин');
        if($password == "") throw new Exception('ви не вели password');
        // створили раньше
        $install = new Install();
        if (!$install->getDBAdmin($login, $password)) {
            die("чат успешно установлен васяя");
        }
    } catch (Exception $e) {
        die($e->getMessage());
    }
}

include_once '__install.php';


?>