<?php
abstract class Expression{
  private $key;
  abstract function interpreter(InterpreterContext $context);
  function getKey(){
  		$this->key = self::$keycount;
  	return $this->key;
class LiteralExpression extends Expression{

	function __construct($value){
	function interpreter(InterpreterContext $context){
class InterpreterContext{

	function replace(Expression $exp, $value){
	function lookup(Expression $exp){
class VariableExpression extends Expression{
	private $val;

	function __construct($name,$val=null){
		$this->val = $val;
	function interpreter(InterpreterContext $context){
			$this->val = null;
	function setValue($value){
	function getKey(){
$context = new InterpreterContext();
$muvar = new VariableExpression('input','����');
$muvar->interpreter($context);
print $context->lookup($muvar);

$var = new VariableExpression('input');
$var->interpreter($context);
print $context->lookup($var);

//�������� �������� ����������
$muvar->setValue('������');
$muvar->interpreter($context);
print $context->lookup($muvar);

print $context->lookup($var);




?>