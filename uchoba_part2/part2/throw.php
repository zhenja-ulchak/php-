<?php
class Info{ private $message;

 public function message($message){ 	$this->message = $message;
 	$record = preg_match("/[Hello World]/",$this->message);
 	 try{ 	 	if(!$record)
 	 	  throw new Exception ("Текст введенный вами не содержит строки \nHello World\n!!!");
 	 	else
 	 	  return "Отлично, вы ввели \nHello World!\n"; 	 }catch(Exception $e){ 	 	return $e->getMessage(); 	 } }}
$info = new Info();
$imessage = $_GET['message']?$_GET['message']:false;
print $info->message($imessage);