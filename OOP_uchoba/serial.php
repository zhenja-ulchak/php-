<?php
class serial{
  public $age = 22;

  function __sleep(){
      return print 'start serialize';
  }
  function __wakeup(){
    return print 'stop serialize';
}
function __toString(){
    return 'вы пытаэтесь визвать обект';
}


}

$a = new serial();
$array = array(1 =>"hello", 2 => "world");
$go = serialize($array);
print "<br> засереалтзовано".$go;
 $s = unserialize($go);
print_r ($s);
?>