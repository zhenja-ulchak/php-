<?php
 interface Observable{ 	function attach(Observer $observer);
 	function detach(Observer $observer);
 	function notify(); }
 interface ObserveableObj{ 	function update(Subject $subject); }
 class Subject implements  Observable{ 	private $observers,$value;

 	public function __construct(){ 		$this->observers = array(); 	}
 	public function attach(Observer $observer){ 		$this->observers[] = $observer; 	}
 	public function detach(Observer $observer){ 		if($id = array_search($observer,$this->observers,true)){ 		  unset($this->observers[$id]); 		} 	}
 	public function notify(){ 		foreach($this->observers as $observer){ 			$observer->update($this); 		} 	}
 	public function setValue($value){ 		$this->value = $value;
 		$this->notify(); 	}
 	public function getValue(){ 		return $this->value; 	} }
 class Observer implements ObserveableObj{ 	public function update(Subject $subject){ 	  echo "<p>��������� ������:".$subject->getValue()."</p>"; 	} }
 //����� ������
 $new_article_sute = new Subject();
 //��������� �����
 $user_one = new Observer();
 //��������
 $new_article_sute->attach($user_one);
 echo "�������� ����� ����� 1";
 //���������� ������
 $new_article_sute->setValue('������ ����� 1');
 $new_article_sute->setValue('������ ����� 2');
 $new_article_sute->setValue('������ ����� 3');

 ////////////////////////////////

 $user_two = new Observer();
  //��������
 $new_article_sute->attach($user_two);
  echo "<hr /><br />�������� ����� 2";
$new_article_sute->setValue('������ ����� 4');
//���������� �����
 $new_article_sute->detach($user_two);
 $new_article_sute->setValue('������ ����� 5');



?>

