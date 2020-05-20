<?php
  abstract class Lesson{
    private $duration;
    private $costStrategy;

  	public function __construct($duration, CostStrategy $costrategy){
  		$this->costStrategy =  $costrategy;
  	public function cost(){
  	}
    public function chargeType(){
    public function getDuration(){

  abstract class CostStrategy{
  	abstract function chargeType();
  class TimedStrategy extends CostStrategy{
  	 public function chargeType(){
        return "��������� ������";
     }
  class FixedStrategy extends CostStrategy{
  	 	return 30;
  	 }
  	 public function chargeType(){
        return "������ �� ���� ������";
     }
  class Lecture extends FixedStrategy{
?>