<?php

 $mod_class = "MyMod";
 $path =  "{$mod_class}.php";
 if(!file_exists($path))
    die("Файла не существует");
 else
    require_once ($path);
 if(!class_exists($mod_class)){ 	die('Разработчик, читай мануал. Класс должен совпадать с именем файла'); }
 $obj = new $mod_class();
 print $obj->hello();
?>

