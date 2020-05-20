<?php
  class SuperUser{  	 protected $prava;
  	 protected $userName;

   public function __construct($prava,$name){	     $this->prava = $prava;
	     $this->userName = $name;
   }
  public function getUser(){
  	 	return "Права:\n".$this->prava."\n".$this->userName;  }

  }
  class Admin extends SuperUser{
    public $g11o;
  public function __construct($prava,$name,$go=1){  	  parent::__construct($prava,$name);
  	  $this->go = $go;  }
   public function getUser(){    	return parent::getUser();    }  }
  class Moderator extends SuperUser{
    public function __construct($prava,$name,$go=0){
  	  parent::__construct($prava,$name);
  }

   public function getUser(){
    	return parent::getUser();
    }  }
  class User extends SuperUser{   public function __construct($prava,$name,$go=0){
  	  parent::__construct($prava,$name);
  }

   public function getUser(){
    	return parent::getUser();
    }  }
  $SuperUser = new SuperUser(10000,"Супер Юзер");
  $admin = new Admin(5000,"Администратор");
  $moder = new Moderator(1000,"Модератор");
  $user = new User(100,"Пользователь");
  print $SuperUser->getUser();
  print "<br />";
  print $admin->getUser();
  print $admin->go;
   print "<br />";
  print $moder->getUser();
   print "<br />";
  print $user->getUser();
  print "<br />";
  if($user instanceof SuperUser)
     print "Класс USER связан с классом SuperUser";
  else
     print "Класс юзер не связан с классом админ";


?>