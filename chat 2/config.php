<?php
 session_start();
 if(!file_exists($_SERVER['DOCUMENT_ROOT']."/db/chat.db"))
      die("<h1>DATABASE NOT FOUND</h1>");
 set_include_path(get_include_path() .";/home/chat/www/");
 error_reporting(E_ALL & ~E_NOTICE);
 function __autoload($className){
     require_once "class/{$className}.class.php";
 }
 define("PATH","http://".$_SERVER['SERVER_NAME']);
 define("SERVER_URL",$_SERVER['DOCUMENT_ROOT']);

?>