<?php

class delete{
    private $db;
    function __construct(){
	try{
	   if(!$this->db = new SQLiteDatabase($_SERVER['DOCUMENT_ROOT']."/db/chat.db"))
		   throw new Exception("Ошибка соединения с сервером");
        }catch(Exception $e){
	    die($e->getMessage());
	}
    }
    function __destruct(){
	unset($this->db);
    }
    public function deleteroom($id){
      $sql = "DELETE FROM room WHERE id = $id";
      $sql_1 = "DELETE FROM message WHERE roomid=$id";
      
      $result = $this->db->query($sql) or die(sqlite_error_string($this->db->lastError()));
      $result_1 = $this->db->query($sql_1) or die(sqlite_error_string($this->db->lastError()));
      
      return true;
    }
    public function deleteusers($id){
      $sql = "DELETE FROM users WHERE id=$id";
      $result = $this->db->query($sql) or die(sqlite_error_string($this->db->lastError()));
      
      
      return true;
    }
}  
?>
