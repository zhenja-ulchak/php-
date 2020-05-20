<?php
class A{
 private $var;	function __construct($var){		$this->var = $var;	}
    private function fr(){
  	return $this->var;
  }}
class B extends A{   function __construct($var){   	parent::__construct($var);   }}

$a = new A(55);
$b = new B(44);
print get_parent_class($b);//Вернет родительский класс
if(is_subclass_of($b,'A')){	print "Класс B дочерний от класса А";}

/*  $one = get_class_methods($a);
  $methods = $one[1];
  if(method_exists($a,$methods)){
    print $a->$methods();
  }
  else
   die('Данного метода не существует');
   */
 ?>

