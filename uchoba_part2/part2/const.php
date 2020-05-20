<?php
  class MyClass{  	const AVR = 1;
  	const BVR = 5;

  	function result(){  		return self::AVR;  	}  }
  print MyClass::result();
  print MyClass::BVR;
?>