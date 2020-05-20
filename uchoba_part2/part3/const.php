<?php
class A{ function getResultMethod(){ 	return __METHOD__; }
 function getResultClass(){ 	return __CLASS__; }}
$a = new A();
print "Метод:".$a->getResultMethod();
print "<br />Класс:".$a->getResultClass();
?>