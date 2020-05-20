<?php
  class L{  	private $variable = 1;
  	private $copy = "&copy; 2011";

  	public function getSong(){  		return $this->variable.$this->copy;  	}  }
  $l = new L();
  print $l->getSong();
?>