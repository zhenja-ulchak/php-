<?php
header('Content-type:text/html; charset=windows-1251');
header("Expires:",date("r"));
header('Last-Modified:'.gmdate('D, d M Y H:i:s')."GMT");
header('Cache-Control:no-store,no-cache,must-revalidate');

require_once 'install.php';
$result = "";
if(file_exists("../db/chat.db")) die("��� ��� ����������");
if($_POST){
    $login = trim(strip_tags($_POST['login']));
    $password = md5($_POST['password']);
   try{
       if($login == "") throw new Exception('�� �� ����� �����!');
       if($password == "") throw new Exception("�� �� ����� ������!");
       $install = new Install();
       if(!$install->getDBAdmin($login,$password)){
	   unset($install);
	   unlink("../db/chat.db");
       }else{
	   die("<center><h2>�������, ��� ������� ����������!!!</h2></center>");
       }
   }catch(Exception $e){
       die($e->getMessage());
   }
}
include_once '__install.php';
?>
