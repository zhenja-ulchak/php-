<?php
  class Serialized{  	public $age = 22;

  	function __sleep(){  		return print 'Start Serialized';  	}
  	function __wakeup(){  		return print 'Stop serialized';  	}
  	function __toString(){  	 return 'Вы пытаетесь вызвать объект';  	}
  	function arr(){  		$array = array(1 =>"Hello", 2 => "My", 3=> "Forever", 4 => "World");  		return  $array;  	}  }
  $serialize = new Serialized();

  $go = serialize($serialize->arr());
  print "<br />Засериализованно: \n".$go;
  print "<br />";
   unserialize($go);
  print_r($serialize->arr());


?>
