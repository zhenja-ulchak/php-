<?php
 abstract class A{
   private $property;
    function __construct(){
 	function getProperty(){

  function classDt(ReflectionClass $class){
  	$className = $class->getName();
  	if($class->isInternal())
  	     $result .= "{$className} - ���������� �����";
  	if($class->isInterface())
  	     $result .= "{$className} - ���������";
  	if($class->isAbstract())
  	     $result .= "{$className} - ����������� �����";
  	if($class->isFinal())
  	     $result .= "{$className} - ��������� �����";

  	return $result;
  function methodDt(ReflectionMethod $method){
  	$result = "";
  	if($method->isPublic())
  	   $result .= "{$name} - ��� ������������� �����";
  	if($method->isConstructor())
  	   $result .= "{$name} - �����������";

  	 return $result;
  function argDt(ReflectionParameter $arg){
  	 $name = $arg->getName();
  	 $class = $arg->getClass();
  	 if(!$class){
  	 	$result .= "{$name} ������ ���� �������� ���� {$classname}";
  	 if($arg->isPassedByReference())
  	   $result .= "{$name} - ������� �� ������";

  	 return $result;
  $a = new ReflectionClass('A');
  $method = $a->getMethod('Result');
  $param = $method->getParameters();
  /*foreach($method as $mm){
  	print "<br />";

  foreach($param as $pp){
  print classDt($a);


?>