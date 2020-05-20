<?php
require_once 'config.php';
class insert{
    private $db;
    function __construct(){
	try{
	   if(!$this->db = new SQLiteDatabase($_SERVER['DOCUMENT_ROOT']."/db/chat.db"))
		   throw new Exception("������ ���������� � ��������");
        }catch(Exception $e){
	    die($e->getMessage());
	}
    }
    function __destruct(){
	unset($this->db);
    }
    function newInsert($login,$password,$email){
	try{
	    $login = sqlite_escape_string($login);
	    $email = sqlite_escape_string($email);
            $date = time();
	    $mz_result = $this->db->query("INSERT INTO users(login,email,password,date)
		                           VALUES('$login','$email','$password','$date')");
	    if(!$mz_result)
		throw new SQLiteException(sqlite_error_string($this->db->lastError()));
	    else return true;
	}catch(SQLiteException $e){
	    die("������ ��� ���������� � ��:\n".$e->getMessage());
	}
    }
    public function newTheme($id,$title,$description){
       try{
           $title = sqlite_escape_string($title);
           $description = sqlite_escape_string($description);
           $sql = "INSERT INTO room(userid,title,description)
                      VALUES('$id','$title','$description')";
           $mz_result = $this->db->query($sql);
           if(!$mz_result)
             throw new SQLiteException(sqlite_error_string($this->db->lastError()));
            else
              return true;  
           }
           catch(SQLiteException $e){
               die($e->getMessage());
           }
    }
    public function getMessage($roomid,$message,$id){
       try{
           $rid = sqlite_escape_string($roomid);
           $date = time();
           $message = sqlite_escape_string($message);
           $id = (int)$id;
           
           
           $sql = "INSERT INTO message(userid,roomid,messages,date)
                   VALUES($id,'$rid','$message','$date')";
           $mz_result = $this->db->query($sql);
           if(!$mz_result)
              throw new SQLiteException(sqlite_error_string($this->db->lastError()));
           else
               return true;
       } 
       catch(SQLiteException $e){
           die($e->getMessage());       }
    }
}
?>
