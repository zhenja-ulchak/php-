<?php
  class Serialized{

  	function __sleep(){
  	function __wakeup(){
  	function __toString(){
  	function arr(){
  $serialize = new Serialized();

  $go = serialize($serialize->arr());
  print "<br />����������������: \n".$go;
  print "<br />";
   unserialize($go);
  print_r($serialize->arr());


?>