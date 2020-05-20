<?php


class Name{
    // оголошуєм глобальну перемену
     public $name;
    //  створюєм функцію 
     function getName($name) {
        // $this-> шото в текущому класы або цей обэкт         
        $this->name = $name;
        // ВЕРТАЄМ ПАРАМЕТЕР
        return $this->name;
     }
}

$name = new Name ();
// предаэм  $name->getName("женя") в функцыю
print $name->getName("женя");







class Surname{
    public $surname;
    function getsurname($sur) {
        $this->surname = $sur;
        return $this->surname;

    }

}
$ret = new Surname();
print $ret->getsurname("ульчак");



class Users{
    public  $qwert;
    function __construct(){
        $this->qwert = "<br> hello vasja";
    }
    function show (){
        return $this->qwert;
    }


}
$user = new Users ();
print $user->show();


class Users1{
    public $ges;
    // function __construct позволяет объявлять
    //  методы-конструкторы. Классы, в которых объявлен 
    //  метод-констуктор, будут вызывать этот метод при 
    //  каждом создании нового объекта, так что это может 
    //  оказаться полезным, чтобы, например, инициализировать
    //   какое-либо состояние объекта перед его использованием.
    //    Конструктор, ранее совпадавший с названием класса, 
    //    теперь необходимо объявлять как __construct(), что
    //     позволит легче перемещать классы в иерархиях. 
    //     Конструкторы в классах-родителях не вызываются 
    //     автоматически. Чтобы вызвать конструктор, объявленный
    //      в родительском классе, следует обратиться к методу 
    //      parent::__construct().
    function __construct(){
        $this->ges = "&nbsp; i am zhenja";
    }
    function shoW (){
        // вертаэм значення перемену гес
        return $this->ges;
    }

}
// тут ясно задаэм прототип класса ы виводим значеня на екран
$user11 = new Users1();
print $user11->show();

// НАСЛЕДОВАНИЕ 
class SuperUser {
        protected $prava;
        protected $userName;
    public function __construct($prava,$name){
        $this->prava = $prava;
        $this->userName = $name;
    }

        public function getUser(){
            return "Права:\n".$this->prava."\n".$this->userName;
        } 

 }          // extends це наследование класа
 class Admin extends SuperUser{
     public function __construct($prava,$name,$go = 1){
        parent::__construct($prava,$name);
     }



        public function getUser() {
         // parent:: копыровання з родительського класа 
       // або $this->prava тоже самоє
           return parent::getUser();
        } 
    }
    class Moderator extends SuperUser{
        public function __construct($prava,$name,$go = 0){
            return parent::__construct($prava,$name);
         }
    
    
    
            public function getUser() {
             // parent:: копыровання з родительського класа 
           // або $this->prava тоже самоє
           return parent::getUser();
            }
    }
    class User extends SuperUser{
        public function __construct($prava,$name,$go = 0){
            parent::__construct($prava,$name);
         }
    
    
    
            public function getUser() {
             // parent:: копыровання з родительського класа 
           // або $this->prava тоже самоє
                return parent::getUser();
            }
    }
$SuperUser = new SuperUser (100000,"&nbsp;супер юзер");
$Admin = new Admin (50000,"&nbsp;АДМИНИСТРАТОР");
$Moderator = new Moderator (10000,"&nbsp;МОДЕРАТОР");
$User = new User (1000,"&nbsp;ЮЗЕР");
print "<br />";
print $SuperUser->getUser();
print "<br />";
print $Admin->getUser();
print "<br />";
print $Moderator->getUser();
print "<br />";
print $User->getUser();


class MyTest{
    static public $qw;

    function gr(){
        // self - вызываем метод именно этого класса
        self::$qw = 5555555;
        return self::$qw;
    }

}
echo MyTest::gr();

?>