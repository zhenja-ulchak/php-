<?php
 class json{
 	private $_result;

 	function __construct($array){
 		  return false;

 		$this->_array = $array;
 	function jsondecode(){

 		return $result;
 	function jsonencode(){

 		return $this->_result;
 $array = array(1 =>"Hello", 2 => "My", 3=> "Forever", 4 => "World");

 $json = new json($array);
 //��������
 echo $json->jsonencode();
 $str = $json->jsonencode();
 if(!file_put_contents('text.txt',$str))
   return false;

 echo "���� ������";

 echo "<br />";
 $f = file_get_contents('text.txt');
 foreach($json->jsondecode() as $text){


?>