<?php
class A{	public $a =5;
	public $b =6;
	public $c=7;
}
class B{}
$a = new A();
$b = new B();

if($a instanceof A)
  print "������ ������ ����������� ������ �";
else
  print "������ ������ �� ����������� ������ �";
 print "<br/>";
print_r(get_class_vars('A'));


?>
