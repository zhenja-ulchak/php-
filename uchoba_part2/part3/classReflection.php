<?php
 abstract class A{
   private $property;
    function __construct(){    	$this->property = 250;    } 	public function Result($result){ 		return $result; 	}
 	function getProperty(){ 		return $this->property; 	} }

  function classDt(ReflectionClass $class){  	$result = "";
  	$className = $class->getName();
  	if($class->isInternal())
  	     $result .= "{$className} - ���������� �����";
  	if($class->isInterface())
  	     $result .= "{$className} - ���������";
  	if($class->isAbstract())
  	     $result .= "{$className} - ����������� �����";
  	if($class->isFinal())
  	     $result .= "{$className} - ��������� �����";

  	return $result;  }
  function methodDt(ReflectionMethod $method){  	$name = $method->getName();
  	$result = "";
  	if($method->isPublic())
  	   $result .= "{$name} - ��� ������������� �����";
  	if($method->isConstructor())
  	   $result .= "{$name} - �����������";

  	 return $result;  }
  function argDt(ReflectionParameter $arg){  	 $result ="";
  	 $name = $arg->getName();
  	 $class = $arg->getClass();
  	 if(!$class){  	 	$classname = $arg->getName();
  	 	$result .= "{$name} ������ ���� �������� ���� {$classname}";  	 }
  	 if($arg->isPassedByReference())
  	   $result .= "{$name} - ������� �� ������";

  	 return $result;  }
  $a = new ReflectionClass('A');
  $method = $a->getMethod('Result');
  $param = $method->getParameters();
  /*foreach($method as $mm){  	print methodDt($mm);
  	print "<br />";  } */

  foreach($param as $pp){  	print argDT($pp);  }
  print classDt($a);


?>