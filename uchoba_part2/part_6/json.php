<?php
 class json{ 	private $_array;
 	private $_result;

 	function __construct($array){ 		if(!is_array($array))
 		  return false;

 		$this->_array = $array; 	}
 	function jsondecode(){ 		$result = json_decode($this->_result,true);

 		return $result; 	}
 	function jsonencode(){ 		$this->_result = json_encode($this->_array);

 		return $this->_result; 	} }
 $array = array(1 =>"Hello", 2 => "My", 3=> "Forever", 4 => "World");

 $json = new json($array);
 //Кодируем
 echo $json->jsonencode();
 $str = $json->jsonencode();
 if(!file_put_contents('text.txt',$str))
   return false;

 echo "Файл создан";

 echo "<br />";
 $f = file_get_contents('text.txt');
 foreach($json->jsondecode() as $text){ 	echo $text."\n"; }


?>
