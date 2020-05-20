<?php
header('Content-type:text/html; charset=windows-1251');
class Install{
    private $_db;
    private $path;
    const DB_INSTALL = "chat.db";
  function __construct(){
      $this->path = "../db/";
      if(!file_exists($this->path.self::DB_INSTALL)){
	  try{
	      $this->_db = new SQLiteDatabase($this->path.self::DB_INSTALL);
	      $sql_users = "CREATE TABLE users(
		            id INTEGER PRIMARY KEY,
			    login TEXT,
			    name TEXT,
			    email TEXT,
			    password TEXT,
			    access INTEGER,
			    age INTEGER,
			    gender TEXT,
			    date TEXT )";
	      $sql_messages = "CREATE TABLE message(
		                id INTEGER PRIMARY KEY,
                                userid INTEGER,
                                roomid INTEGER,
				messages TEXT,
				date TEXT)";
              $sql_room = "CREATE TABLE room(
                            id INTEGER PRIMARY KEY,
                            userid INTEGER,
                            title TEXT,
                            description TEXT)";
	      $mz_users = $this->_db->query($sql_users);
	      $mz_messages = $this->_db->query($sql_messages);
              $mz_room = $this->_db->query($sql_room);
	      if(!$mz_users) 
		  throw new SQLiteException(sqlite_error_string($this->_db->lastError()));
	      if(!$mz_messages)
		  throw new SQLiteException(sqlite_error_string($this->_db->lastError()));
	      if(!$mz_room)
                  throw new SQLiteException(sqlite_error_string($this->_db->lastError()));

              
            }
	    catch(SQLiteException $e){
		return "Error:\n".$e->getMessage();
	    }
      }else{
	  $this->_db = new SQLiteDatabase($this->path.self::DB_INSTALL);
	   die("Чат уже установлен, удалите директорию Install!");
      }
  }  
  public function getDBAdmin($login,$password){
      $clear = sqlite_escape_string($login);
      $date = time();
      try{
        $sql_admin = "INSERT INTO users(id,login,password,access,date)
	          VALUES('1','$login','$password','1','$date')";
	$_mzChat = $this->_db->query($sql_admin);
	if(!$_mzChat)
	    throw new SQLiteException(sqlite_error_string($this->_db->lastError()));
	else
	    return true;
       }catch(SQLiteException $e){
	   return "Error:\n".$e->getMessage();
       }
}
function __destruct(){
    unset($this->_db);
    if(!file_exists($this->path.self::DB_INSTALL));
    else unlink($this->path.self::DB_INSTALL);
}

}

?>
