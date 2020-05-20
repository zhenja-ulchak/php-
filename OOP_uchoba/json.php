<?php
class a{
private $_array;
private $_result;

function __construct ($array){
    // перевырка на масив
    if (!is_array($array)) 
    // эсли нет то венертаэм
        return false;
        // якшо масив пердаэм його в конструктор
        $this->_array = $array;
    
    }
    function jsondecode (){
        // наша строка яку вертаєм 
        $result = json_decode($this->_result, true);
        return $result;
    }
    function jsonencode (){
        $this->_result = json_encode($this->_array);
        return $this->_result;
    }




}
// 1 обявляєм масив 
$array = array(1 =>"hello", 2 => "world");
// 2 создаєм обєкт
$a = new a($array);
// 3 виводим
echo $a->jsonencode();
$str = $a->jsonencode();
// (!file_put_contents('text.txt',$str) создайот файл
if (!file_put_contents('text.txt',$str)) 
   return false;
echo "файл создан";
$r = file_get_contents('text.txt');
foreach($a->jsondecode() as $text){
    echo $text."\n";
}




?>