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
 class Observer implements ObserveableObj{ 	public function update(Subject $subject){ 	  echo "<p>Последние статьи:".$subject->getValue()."</p>"; 	} }
 //Новая статья
 $new_article_sute = new Subject();
 //Подписчик сайта
 $user_one = new Observer();
 //Подписка
 $new_article_sute->attach($user_one);
 echo "Подписка юзера номер 1";
 //Добавление статьи
 $new_article_sute->setValue('Статья номер 1');
 $new_article_sute->setValue('Статья номер 2');
 $new_article_sute->setValue('Статья номер 3');

 ////////////////////////////////

 $user_two = new Observer();
  //Подписка
 $new_article_sute->attach($user_two);
  echo "<hr /><br />Подписки юзера 2";
$new_article_sute->setValue('Статья номер 4');
//Отписываем юзера
 $new_article_sute->detach($user_two);
 $new_article_sute->setValue('Статья номер 5');



?>

