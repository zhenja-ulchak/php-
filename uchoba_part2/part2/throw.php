<?php
class Info{

 public function message($message){
 	$record = preg_match("/[Hello World]/",$this->message);
 	 try{
 	 	  throw new Exception ("����� ��������� ���� �� �������� ������ \nHello World\n!!!");
 	 	else
 	 	  return "�������, �� ����� \nHello World!\n";
$info = new Info();
$imessage = $_GET['message']?$_GET['message']:false;
print $info->message($imessage);