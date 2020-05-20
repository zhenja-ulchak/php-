<?php

// class A {
//     private $file;

//     function __construct($file){
//         $this->file = $file;

//     }
//     function __toString(){
//         if (!file_exists($this->file)) {
//             return "файла{$this->file} не существуєт";
//         }else {
//             return file_get_contents($this->file);
//         }
//     }

// }
// $file = "text.txt";
// $a = new A ($file);
// print $a;






class A {
   private $a;
    function __set($var, $value){
        $this->a[$var] = $value;

    }
    function __get($var){
       return $this->a[$var] ;

    }
}
$a = new A();
$a->a = $_GET['name'];
print $a->a;

// Метод __get($property) вызывается при обращении к неопределенному свойству.

// Метод __set($property, $value) вызывается, когда неопределенному свойству присваивается значение.

// Метод __isset($property) вызывается, когда функция isset() вызывается для неопределенного свойства.

// Метод __unset($property) вызывается, когда функция unset() вызывается для неопределенного свойства.

// Метод __call($method, $arg_array) вызывается при обращении к неопределенному методу.
?>