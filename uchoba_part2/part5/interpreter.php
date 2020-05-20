<?php
abstract class Expression{  private static $keycount=0;
  private $key;
  abstract function interpreter(InterpreterContext $context);
  function getKey(){  	if(!isset($this->key)){  		self::$keycount++;
  		$this->key = self::$keycount;  	}
  	return $this->key;  }}
class LiteralExpression extends Expression{	private $value;

	function __construct($value){		$this->value = $value;	}
	function interpreter(InterpreterContext $context){		$context->replace($this,$this->value);	}}
class InterpreterContext{	private $expression = array();

	function replace(Expression $exp, $value){		$this->expression[$exp->getKey()] = $value;	}
	function lookup(Expression $exp){		return $this->expression[$exp->getKey()];	}}
class VariableExpression extends Expression{	private $name;
	private $val;

	function __construct($name,$val=null){		$this->name = $name;
		$this->val = $val;	}
	function interpreter(InterpreterContext $context){		if(!is_null($this->val)){			$context->replace($this,$this->val);
			$this->val = null;		}	}
	function setValue($value){		$this->val = $value;	}
	function getKey(){		return $this->name;	}}
$context = new InterpreterContext();
$muvar = new VariableExpression('input','Пять');
$muvar->interpreter($context);
print $context->lookup($muvar);

$var = new VariableExpression('input');
$var->interpreter($context);
print $context->lookup($var);

//Изменить значение переменной
$muvar->setValue('Десять');
$muvar->interpreter($context);
print $context->lookup($muvar);

print $context->lookup($var);




?>
