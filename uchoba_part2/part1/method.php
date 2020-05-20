<?php
 class Name{ 	public $name;

 	function getName($name){ 		$this->name = $name; 		return $this->name; 	} }
 $name = new Name();
 print $name->getName();
?>