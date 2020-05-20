<?php
// require_once 'config.php';
class update{
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
    public function updateProfile($up = array()){
        try{
            $name = SQLite3::escapeString($up[0]);
            $gender = SQLite3::escapeString($up[1]);
            $age = SQLite3::escapeString($up[2]);
            $sql = "UPDATE users SET name = '".$name."',
                                     gender = '".$gender."',
                                     age =  '".$age."'
                    WHERE login ='".$_SESSION['user']['login']."'";
            $mz_result = $this->db->query($sql);
            if(!$mz_result)
                throw new SQLiteException(sqlite_error_string($this->db->lastError()));
            else
                return true;
            
        }
        catch(SQLiteException $e){
            die("ошибка при редактировании\n".$e->getMessage());
        }
          
    }
}
?>
