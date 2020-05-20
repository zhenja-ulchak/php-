<?php
  class A{
   private $a;  	/* private $file;

  	 function __construct($file){  	 	 $this->file = $file;  	 }
  	 function __toString(){  	 	if(!file_exists($this->file))
  	 	  return "Файла {$this->file} не существует!";
  	 	else
  	 	  return file_get_contents($this->file);  	 } */

    function __set($var,$value){    	$this->a[$var] = $value;
    	print $var.$value;    }
    function __get($var){    	return  $this->a[$var];    }
    function __call($name,$arg){    	print $name;
    	print_r($arg);    }  }
 /* $file = "text.txt";
  $a = new A($file);
  print $a; */
  $a = new A();
  $a->a = $_GET['name'];
 $a->getName("Привет");
?>