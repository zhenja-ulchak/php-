<?php
 abstract class A{
   private $property;
    function __construct(){    	$this->property = 250;    } 	public function Result($result){ 		return $result; 	}
 	function getProperty(){ 		return $this->property; 	} }

  function classDt(ReflectionClass $class){  	$result = "";
  	$className = $class->getName();
  	if($class->isInternal())
  	     $result .= "{$className} - встроенный класс";
  	if($class->isInterface())
  	     $result .= "{$className} - Интерфейс";
  	if($class->isAbstract())
  	     $result .= "{$className} - Абстрактный класс";
  	if($class->isFinal())
  	     $result .= "{$className} - Финальный класс";

  	return $result;  }
  function methodDt(ReflectionMethod $method){  	$name = $method->getName();
  	$result = "";
  	if($method->isPublic())
  	   $result .= "{$name} - Это общедоступный метод";
  	if($method->isConstructor())
  	   $result .= "{$name} - Конструктор";

  	 return $result;  }
  function argDt(ReflectionParameter $arg){  	 $result ="";
  	 $name = $arg->getName();
  	 $class = $arg->getClass();
  	 if(!$class){  	 	$classname = $arg->getName();
  	 	$result .= "{$name} должен быть объектом типа {$classname}";  	 }
  	 if($arg->isPassedByReference())
  	   $result .= "{$name} - Передан по ссылке";

  	 return $result;  }
  $a = new ReflectionClass('A');
  $method = $a->getMethod('Result');
  $param = $method->getParameters();
  /*foreach($method as $mm){  	print methodDt($mm);
  	print "<br />";  } */

  foreach($param as $pp){  	print argDT($pp);  }
  print classDt($a);


?>