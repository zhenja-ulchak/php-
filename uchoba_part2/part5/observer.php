<?php
 interface Observable{
 	function detach(Observer $observer);
 	function notify();
 interface ObserveableObj{
 class Subject implements  Observable{

 	public function __construct(){
 	public function attach(Observer $observer){
 	public function detach(Observer $observer){
 	public function notify(){
 	public function setValue($value){
 		$this->notify();
 	public function getValue(){
 class Observer implements ObserveableObj{
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
