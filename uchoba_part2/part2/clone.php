<?php

class A{

	function getsText($a){
		return $this->user;
	function __clone(){
		print $this->user;
$a = new A();
$b = clone $a;
print $a->getsText(5);
print "<br />";
print $b->getsText(5);


?>