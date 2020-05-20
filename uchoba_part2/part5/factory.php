<?php
  abstract class Race{  	public function force(){  		$force = 100;  	}
  	public function speed(){
  		$speed = 100;
  	}
  	public function reaction(){
  		$reaction = 100;
  	}
  }
  class Zoombie extends Race{  		public function force(){
  		return $force = 90;
  	}
  	public function speed(){
  		$speed = 10;
  	}
  	public function reaction(){
  		$reaction = 60;
  	}  }
    class Aliens extends Race{
  		public function force(){
  		return $force = 50;
  	}
  	public function speed(){
  		$speed = 90;
  	}
  	public function reaction(){
  		$reaction = 40;
  	}
  }
    class Vampires extends Race{
  	public function force(){
  		return $force = 30;
  	}
  	public function speed(){
  		$speed = 80;
  	}
  	public function reaction(){
  		$reaction = 90;
  	}
  }
  class Trols extends Race{
  	public function force(){
  		return $force = 100;
  	}
  	public function speed(){
  		$speed = 90;
  	}
  	public function reaction(){
  		$reaction = 80;
  	}
  }
  class StartGame{  	public static $race = array(1 => "Aliens",
  	                             2 => "Zoombie",
  	                             3 => "Vampires",
  	                             4 => "Trols");
  	static function create_race($ch){  		  return new self::$race[$ch]();  	}  }
  $race = StartGame::create_race(1);
  print "Сила".StartGame::$race[1].":". $race->force();


?>

