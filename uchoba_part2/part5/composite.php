<?php
 abstract class Unit{
 	abstract function removeUnit(Unit $unit);
 	abstract function forceunitofunion();
 class Tech extends Unit{
 	function addUnit(Unit $unit){
 		$this->units[] = $unit;
 	function removeUnit(Unit $unit){
 		//�������� ���
       $this->units = $unit; // 90 - 30 + 100 = 190
 	 function forceunitofunion(){
 	 	foreach($this->units as $unit){

 	 	return $res;


?>