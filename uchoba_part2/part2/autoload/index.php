<?php
  function __autoload($className){  	require_once "{$className}.class.php";  }
  $a = new one();
  $b = new two();
  $c = new three();

  print $a->getName();
  print $b->getName();
  print $c->char;
?>