<?php
// class Worker{
//     private $name;
//     private $salary;

//     public function __construct($name, $salary){
//         echo $name;
//         echo $salary;
//     }


// }

// $a = new Worker("женя", 2500);




class User{
    private $name;
    private $age;

    public function getName(){
        return $this->name;
 
     }
    public function setName($name){
        $this->name = $name;

    }
    public function getAge(){
        return $this->age;
 
     }
    public function setAge($age){
        $this->age = $age;

    }
 


}

class a extends User{
    private $salary;

    public function getSalary(){
        return $this->salary;
    }
    public function setSalary($salary){
            $this->salary = $salary;
    }


}


$A = new a ();
$A->setName("хуй");
$A->setAge(20);
$A->setSalary(3500);

echo $A->getName();
print "<br>";
echo $A->getAge();
print "<br>";
echo $A->getSalary();


class driver extends User{
    private $categorii;
    private $staj;

    public function  setCategorii($categorii){
        $this->categorii = $categorii;

    }
    public function  getCategorii(){
        return $this->categorii;
        
    }
    public function  setStaj($staj){
        $this->staj = $staj;
        
    }
    public function  getStaj(){
        return $this->staj;
        
    }
}
    $avto = new driver ();
    $avto->setCategorii('A');
    echo $avto->getCategorii();
    $avto->setStaj('2 года');
    echo $avto->getStaj();

?>