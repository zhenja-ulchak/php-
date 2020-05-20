<?php

class A{	private $user;

	function getsText($a){		$this->user = $a;
		return $this->user;	}
	function __clone(){		$this->user = 10 ;
		print $this->user;	}}
$a = new A();
$b = clone $a;
print $a->getsText(5);
print "<br />";
print $b->getsText(5);


?>