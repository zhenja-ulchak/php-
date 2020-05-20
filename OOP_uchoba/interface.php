<?php
// чертьож интерфейса 
interface A{
    // тильки обявляэш function getMess(); без тела фунции
    function getMess();
    function getShow();

}
interface B{
    function getReslt();
   

}
// 
class mails{

}
// реализация implements- це наследоываниэ интерфейса
class myclass extends mails implements A,B{
    public function getMess(){
        return "masege";
    }
    public function getShow(){
        return "Show";
    }
    public function getReslt(){
        return "Reslt";
    }
}
// 
$a = new myclass();
print $a->getMess();

// интерфейс допомагаэ нвлидувати быльше класив (интерфесив )

?>