<?php
    class worker {
        public $name;
        public $age;
        public $salary;
        

        public function getname ($name){
            $this->name = $name;
            return $name;

        }
        public function getage ($age){
            $this->age = $age;
            return $age;

        }
        public function getsalary ($salary){
            $this->salary = $salary;
            return $salary;

        }
        public function obj1 (){
            $this->getname($name = "sgskf");
            print getname();
        }
    


        
    }
  




    $a = new worker();
    $s = new worker();
    print $a->getname("вася");
    print "<br>";
    print $a->getage("25 лет");
    print "<br>";
    print $a->getsalary("зарплата: 2500 грн");
    print "<br>";
    print "<br>";
    print $s->getname("петя");
    print "<br>";
    print $s->getage("28 лет");
    print "<br>";
    print $s->getsalary("зарплата: 4000 грн");

    class a {
        private $name;
        private $age;
        private $salary;

        public function setName ($name) {
            $this->name = $name;
            

        }
        public function getName () {
            return $this->name;
           
            
        }
        public function setAge ($age) {
           if ($this->checkAge ($age)) {
            $this->age = $age;
           }
            
           
            
        }
        private function checkAge ($age){
            if ($age < 100) {
                return true;
            }else {
                return  false;
            }
        }


        public function getAge () {
           return $this->age;
            
        }
        public function setSalary ($salary) {
            $this->salary = $salary;
            
        }
        public function getSalary () {
           return $this->salary;
            
        }
        


    }
    $A = new a();
    $q = new a();



     $A->setName('<br>'.'вася');
     echo $A->getName();
     $A->setAge(102);
     echo $A->getAge();
      $A->setSalary('<br>'.'2500');
      echo $A->getSalary();


      $q->setName('<br>'.'петя');
      echo $q->getName();
      $q->setAge('<br>'.'23');
      echo $q->getAge();
       $q->setSalary('<br>'.'24440');
       echo $q->getSalary();


?>