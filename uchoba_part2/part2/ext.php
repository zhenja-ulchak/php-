<?php
 class ExtFiles extends Exception{ 	private $errorName;

 	function __construct($error){ 		$this->errorName = $error; 	}

 	function result(){ 		return "������:\n".$this->errorName."\n������:\n"; 	} }
 class ExtDB extends Exception{ 		private $errorName;

 	function __construct($error){
 		$this->errorName = $error;
 	}

 	function result(){
 		return "������:\n".$this->errorName."\n������:\n";
 	} }
 class A{

 	public function getConnect($file,$db){ 		try{ 		 if(!file_exists($file))
 		   throw new ExtFiles("���� �� ������!");
 		 else
 		   print file_get_contents($file);


 		 //���� ������
 		 if(!mysql_connect('localhost','root','333'))
 		         throw new ExtDB('������ ��� ���������� � ��');
 		 elseif(!mysql_select_db($db))
 		         throw new ExtDB('������ ��� ����������� � ��.....'); 		}catch(ExtFiles $e){ 			return $e->result().$e->getLine(); 		}catch(ExtDB $e){ 			return $e->result().$e->getLine(); 		} 	} }
 $a = new A();
 print $a->getConnect('test.txt','mybase1');
?>