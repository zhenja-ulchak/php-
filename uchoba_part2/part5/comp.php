<?php
  abstract class Lesson{
    private $duration;
    private $costStrategy;

  	public function __construct($duration, CostStrategy $costrategy){  		$this->duration = $duration;
  		$this->costStrategy =  $costrategy;  	}
  	public function cost(){  		return $this->costStrategy->cost($this);
  	}
    public function chargeType(){        return $this->costStrategy->chargeType();    }
    public function getDuration(){    	return $this->duration;    }
  }
  abstract class CostStrategy{  	abstract function cost(Lesson $lesson);
  	abstract function chargeType();  }
  class TimedStrategy extends CostStrategy{  	 public function cost(Lesson $lesson){  	 	return ($lesson->getDuration() * 5);  	 }
  	 public function chargeType(){
        return "Почасовая оплата";
     }  }
  class FixedStrategy extends CostStrategy{  	 public function cost(Lesson $lesson){
  	 	return 30;
  	 }
  	 public function chargeType(){
        return "Оплата за весь период";
     }  }
  class Lecture extends FixedStrategy{  	public function result(){  		return $this->chargeType()."\n".$this->cost();  	}  }
?>