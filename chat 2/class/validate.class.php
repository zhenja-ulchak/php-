<?php
require_once 'insert.class.php';
require_once 'select.class.php';
class validate extends insert{
  public function toString(){
      return $this->validation($arr);
  }
  public function validation($arr){
   if($arr['login'] == "") print("�� �� ����� �����!<br />");
   if($arr['password'] == "") print("�� �� ����� ������!<br />");
   if($arr['email'] == "") print("�� �� ����� email �����!<br />");
   $select = new select();
   $login = trim(strip_tags($arr['login']));
   $password = md5($arr['password']);
   $email = trim(strip_tags($arr['email']));
   if(!$select->getEmail($email));

   $insert = new insert();
   if(!$insert->newInsert($login,$password,$email));
   else{
       $_SESSION['user']['login'] = $login;
       die("�� ������� �����������������");
   }
  }
}

?>
