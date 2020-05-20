<?php

define('LIB_DIR', __DIR__ . '/modules/');

spl_autoload_register(function($class) {
	
	$a = explode('\\', $class);
	$last = array_pop($a);
	$fn = $class . '/' . $last . '.php';
	$fn = LIB_DIR . str_replace('\\', '/', $fn);
	
	echo '<b>autoload: ' . $class . '</b> file: ' . $fn . '<br>';
 
	if (file_exists($fn)) require $fn; 
});


$o1 = new lib\Class1();
$o2 = new lib\Class2();
$o3 = new lib\Class1\SubClass1();


# end of file