<?php
  class Users{  	public  $variable;  	function __construct($text,$text2){  		$this->variable = $text.$text2;  	}
  	function show(){  		return $this->variable;  	}  }
  $user = new Users("������ �����","������ ���� �����������..");
  print $user->show();
?>