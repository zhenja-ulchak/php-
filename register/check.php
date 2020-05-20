<?php
// ФІЛЬТЕР // Фильтрует переменную с помощью определенного фильтра
// Удаляет теги, при необходимости удаляет или кодирует специальные символы.
$login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']),FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);
// перевірка на дліну
if(mb_strlen($login) < 5 || mb_strlen($login) > 90) {
    echo "недопустимая длинна логина";
    exit();
}elseif(mb_strlen($name) < 3 || mb_strlen($name) > 50) {
    echo "недопустимая длинна имя";
    exit();
}elseif(mb_strlen($pass) < 2 || mb_strlen($pass) > 6) {
    echo "недопустимая длинна от 2 до 6 символов";
    exit();
}
// таже срань кодіровка
    $pass = md5($pass."dfh5dbda45gbh453kllkgxd45mk45gdshsfj58637");
$mysql = new mysqli('localhost','root','','register');
$mysql->query("INSERT INTO `users` (`login`, `pass`, `name`) 
VALUES('$login', '$pass', '$name')");
$mysql->close();
header('location:/')

// $mysql->query("INSERT INTO `users` (`login`, `pass`, `name`) 
// VALUES('$login', '$pass', '$name')"); правильний запрос на вставку в базу

?>




