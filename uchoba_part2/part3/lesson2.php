<?php

 $mod_class = "MyMod";
 $path =  "{$mod_class}.php";
 if(!file_exists($path))
    die("����� �� ����������");
 else
    require_once ($path);
 if(!class_exists($mod_class)){ 	die('�����������, ����� ������. ����� ������ ��������� � ������ �����'); }
 $obj = new $mod_class();
 print $obj->hello();
?>

