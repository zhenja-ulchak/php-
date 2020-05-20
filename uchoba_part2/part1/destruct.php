<?php
  class Avto{  	private $name;
  	private $id;

  	function __construct($name){  		$this->name = $name;  	}
  	function getId($id){  		$this->id = $id;  	}
  	function __destruct(){       print "Работает деструктор";  	}  }
  $avto = new Avto("Имя");
  print $avto->getId(4);
  unset($avto);
?>