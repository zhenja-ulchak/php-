<?php
class A{ function getResultMethod(){ 	return __METHOD__; }
 function getResultClass(){ 	return __CLASS__; }}
$a = new A();
print "�����:".$a->getResultMethod();
print "<br />�����:".$a->getResultClass();
?>