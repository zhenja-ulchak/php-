<?php
require_once 'insert.php';
require_once 'select.php';
// наследование класа
class validate extends insert{
  // таже функ вичислення строковои недостат
  public function toString(){
      return $this->validation($arr);
  }
  public function validation($arr){
   if($arr['login'] == "") print("ви не вели логин!<br />");
   if($arr['password'] == "") print("ви не пароль!<br />");
   if($arr['email'] == "") print("ви не вели email !<br />");

   $select = new select();
   $login = trim(strip_tags($arr['login']));
   $password = md5($arr['password']);
   $email = trim(strip_tags($arr['email']));
   
   if(!$select->getEmail($email));

   $insert = new insert();
   if(!$insert->newInsert($login,$password,$email));
   else{
       $_SESSION['user']['login'] = $login;
       die("ви успешно зарегались");
   }
  }
}

?>
