<?php


require_once 'config.php';
	
    class insert{
    private $db;
    function __construct(){
	    try{
	        if(!$this->db = new SQLite3($_SERVER['DOCUMENT_ROOT']."/db/chat.db"))
		         throw new Exception("ошибка соидинения с сервером");
            }catch(Exception $e){
	            die($e->getMessage());
	        }
    }
    function __destruct(){
	    unset($this->db);
    }
    function newInsert($login,$password,$email){
	    try{
	        // $login = sqlite_escape_string($login);
	        // $email = sqlite_escape_string($email);
            $date = time();
	        $mz_result = $this->db->query("INSERT INTO users(login,email,password,date)
		                           VALUES('$login','$email','$password','$date')");
	        if(!$mz_result)
		        throw new SQLiteException(sqlite_error_string($this->db->lastError()));
	        else return true;
	        }catch(SQLiteException $e){
	    die("ошибка:\n".$e->getMessage());
    	}
	}
	public function newTheme($id,$title,$description){
		try{
			$title = SQLite3::escapeString($title);
			$description = SQLite3::escapeString($description);
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
			$rid = SQLite3::escapeString($roomid);
			$date = time();
			$message = SQLite3::escapeString($message);
			$id = (int)$id;
			
			
			$sql = "INSERT INTO message(userid,roomid,messages,date)
					VALUES($id,'$rid','$message','$date')";
			$mz_result = $this->db->query($sql);
			// if(!$mz_result)
			//    throw new SQLiteException(sqlite_error_string($this->db->lastError()));
			// else
			// 	return true;
		} 
		catch(SQLiteException $e){
			die($e->getMessage());       }
	 }
}
    
?>

    


