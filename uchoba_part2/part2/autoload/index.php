<?php
  function __autoload($className){
  $a = new one();
  $b = new two();
  $c = new three();

  print $a->getName();
  print $b->getName();
  print $c->char;
?>