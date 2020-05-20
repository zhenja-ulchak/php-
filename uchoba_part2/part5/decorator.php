<?php
// комент сверху
 abstract class Resources{
 	abstract function ResResult();
 }
//  наследуэм
 class Plains extends Resources{
 	function ResResult(){
 		//значенння 
 		return 4;
 	}
 }
abstract class ResDecorator{
	private $res = null;
	// являэться контейнером для комент сверху
	// передаэм обэкт $resource
	function __construct(Resources $resource){
		// присваэм сидку на обэкт
		$this->res = $resource;
	}
	// вертаэ силку
	protected function getComponent(){
		return $this->res;
	}
	// вертаэм результат
	public function ResResult(){
		return $this->getComponent()->ResResult();
	}

}
class Diamond extends ResDecorator{
 public function ResResult(){
	return 6;
	}
}
// наследуэм
class Gold extends ResDecorator{

 public function ResResult(){
	//  обращаэт до родительськго класа с возвратом
	return parent::ResResult();
 }
}
$diamond = new Diamond(new Plains());
$gold = new Gold(new Plains());

print "диаманти:". $diamond->ResResult();
print "<br />";
print "золото:". $gold->ResResult();
?>
