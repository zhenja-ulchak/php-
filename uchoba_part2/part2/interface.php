<?php
interface A{	function getMessage();
	function getShow();}
interface B{	function getResult($param);}
class Mails{	//Реализация}
class MyClass extends Mails implements A,B{	public function getMessage(){		return "Message";	}
	public function getShow(){		return "Show";	}
	public function getResult($param = NULL){		return "Result";	}}
 $a = new MyClass();
 print $a->getResult();

?>

