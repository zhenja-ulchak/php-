<?php
class A{
	// етот клас будет клонироватса 
	public function __clone(){
		return "клонирование";
	}
	public function __toString(){
		return 'hello';
	}
}
// создайом обэкт класа а
$prototype = new A();
// обэкт клонирует обэкт 
$obj = clone $prototype;
print $obj;
print $prototype;


?>
