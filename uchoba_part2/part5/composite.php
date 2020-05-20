<?php
 abstract class Unit{ 	abstract function addUnit(Unit $unit);
 	abstract function removeUnit(Unit $unit);
 	abstract function forceunitofunion(); }
 class Tech extends Unit{ 	private $units = array(Zoombie+Aliens); // 60 + 30 = 90
 	function addUnit(Unit $unit){ 		if(in_array($unit, $this->units, true)){ 			return; 		}
 		$this->units[] = $unit; 	}
 	function removeUnit(Unit $unit){ 		$units = array();
 		//Удаление рас
       $this->units = $unit; // 90 - 30 + 100 = 190 	}
 	 function forceunitofunion(){ 	 	$res = 0;
 	 	foreach($this->units as $unit){ 	 	 $res += $unit->forceunitofunion(); 	 	}

 	 	return $res; 	 } }


?>
