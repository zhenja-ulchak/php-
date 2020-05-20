<?php


session_start();
set_include_path(get_include_path() .";/domains/chat/");
spl_autoload_register( function ($class_name) {
	include $_SERVER['DOCUMENT_ROOT']."/class/" .$class_name . '.php';

}) ;













define("PATH","http://".$_SERVER['SERVER_NAME']);
define("SERVER_URL",$_SERVER['DOCUMENT_ROOT']);





?>