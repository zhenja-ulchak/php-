<?php
 class DbConnection{
  	const DB_NAME = 'mydb.db';
  	private $_db;
  	static private $_instance = null;
  	private function __construct(){
  		 $this->_db = new SQLiteDataBase(self::DB_NAME);
	  }
	//   метод клон не дайот скопировать 
  	private function __clone(){}
  	static function getInstance(){
  		if(self::$_instance == null)
  		   self::$_instance = new DbConnection();
       return self::$_instance;
  	}
  }
  $sql = 'SELECT * FROM table';
 /* $db = DbConnection::getInstance();
  $db->query();*/
//   обращаємся до метода getInstance() с запросом
  $db = DbConnection::getInstance()->query($sql);

?>