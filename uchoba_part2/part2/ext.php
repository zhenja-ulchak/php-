<?php
 class ExtFiles extends Exception{ 	private $errorName;

 	function __construct($error){ 		$this->errorName = $error; 	}

 	function result(){ 		return "Ошибка:\n".$this->errorName."\nСтрока:\n"; 	} }
 class ExtDB extends Exception{ 		private $errorName;

 	function __construct($error){
 		$this->errorName = $error;
 	}

 	function result(){
 		return "Ошибка:\n".$this->errorName."\nСтрока:\n";
 	} }
 class A{

 	public function getConnect($file,$db){ 		try{ 		 if(!file_exists($file))
 		   throw new ExtFiles("Файл не найден!");
 		 else
 		   print file_get_contents($file);


 		 //База данных
 		 if(!mysql_connect('localhost','root','333'))
 		         throw new ExtDB('Ошибка при соединении с БД');
 		 elseif(!mysql_select_db($db))
 		         throw new ExtDB('Ошибка при подключении к БД.....'); 		}catch(ExtFiles $e){ 			return $e->result().$e->getLine(); 		}catch(ExtDB $e){ 			return $e->result().$e->getLine(); 		} 	} }
 $a = new A();
 print $a->getConnect('test.txt','mybase1');
?>