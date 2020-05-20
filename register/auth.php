<?php
// Фильтрует переменную с помощью определенного фильтра
// Удаляет теги, при необходимости удаляет или кодирует специальные символы.
$login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING);
// Фильтрует переменную с помощью определенного фильтра
// Удаляет теги, при необходимости удаляет или кодирует специальные символы.
$pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);
// кодировка для пароля
$pass = md5($pass."mk45gdshsfj58637");
// підключення
$mysql = new mysqli('localhost','root','','register');
// той же запрос до бази витягує дані
$result = $mysql->query("SELECT * FROM `users` WHERE `login` = '".$login."' OR 
`pass` = '".$pass."'");
//  Извлекает результирующий ряд в виде ассоциативного массива(fetch_assoc)
$user = $result->fetch_assoc();
if(count($user) == 0){
    echo "такой пользователь не найден";
    exit();

}
setcookie('user', $user['name'], time() + 3600, "/");



$mysql->close();
header('location:/');
// WHERE `login` = '$login' AND 
// `pass` = '$pass'

?>