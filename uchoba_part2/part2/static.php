<?php
 class MyTest{ 	 public $property;

 	function getResult(){
 	    self::$property = 5; 		return self::$property; 	} }
 echo MyTest::getResult();
?>