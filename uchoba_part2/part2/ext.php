<?php
 class ExtFiles extends Exception{

 	function __construct($error){

 	function result(){
 class ExtDB extends Exception{

 	function __construct($error){
 		$this->errorName = $error;
 	}

 	function result(){
 		return "������:\n".$this->errorName."\n������:\n";
 	}
 class A{

 	public function getConnect($file,$db){
 		   throw new ExtFiles("���� �� ������!");
 		 else
 		   print file_get_contents($file);


 		 //���� ������
 		 if(!mysql_connect('localhost','root','333'))
 		         throw new ExtDB('������ ��� ���������� � ��');
 		 elseif(!mysql_select_db($db))
 		         throw new ExtDB('������ ��� ����������� � ��.....');
 $a = new A();
 print $a->getConnect('test.txt','mybase1');
?>