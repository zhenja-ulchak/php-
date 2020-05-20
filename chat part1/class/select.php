<?php

class select{
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
    function getAjax($email){
        // strip_tags — Удаляет HTML и PHP-теги из строки
        $email = strip_tags($email);
        // sqlite_escape_string -- Экранирует спецсимволы в строке для использования в запросе
        // $email = SQLite3::escapeString($email);
        try {
            $sql = "SELECT id,email FROM users WHERE email = '$email'";
            // запрос в перемений до бд 
            $emailResult = $this->db->query($sql);
            if (!$emailResult) {
                throw new Exception("ERROR DB".__LINE__);
            }
            $sqll = $emailResult->fetchArray(SQLITE3_ASSOC);
                // SQLITE3_ASSOC якшо хочем вибрати асоциативний масив
           
            if ($email === $sqll['email']) 
                throw new Exception("такой email уже эсть - ".$sqll['email']);
            else
                throw new Exception("такой email свободний");    

        } catch (Exception $e) {
            die($e->getMessage());
        }
        
    }


    function getEmail($email){
        try {
            $sql = "SELECT id,email FROM users WHERE email = '$email'";
            // запрос в перемений до бд 
            $emailResult = $this->db->query($sql);
            if (!$emailResult) {
                throw new Exception("ERROR DB".__LINE__);
            }
            $sqll = $emailResult->fetchArray(SQLITE3_ASSOC);
                // SQLITE3_ASSOC якшо хочем вибрати асоциативний масив
           
            if ($email === $sqll['email']) 
                throw new Exception("такой email уже эсть - ".$sqll['email']);
             

            } catch (Exception $e) {
                die($e->getMessage());
        }
    }
    function avto($email,$password){
        try{
            $sql = $this->db->query("SELECT id,login,email,password FROM users WHERE email='$email'");
            if(!$sql)
                throw new Exception("Error Database".__LINE__);
                // виводим в асоциативний масив
            $row = $sql->fetchArray(SQLITE3_ASSOC);
            if($row['email'] === $email && $row['password'] === $password){
                // откриваэм сесию
                $_SESSION['user']['login'] = $row['login'];
                return true;
            }
            else die("дание не совпадают");
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function profileUser($login){
        $sql = "SELECT id,login,name,email,age,gender,date FROM users
                 WHERE login = '".$login."'";
                 $result = $this->db->query($sql) or die($this->db->lastError());
                 $row = $result->fetchArray(SQLITE3_ASSOC);
                 return $row;
    }

    public function LoginToId($login){
        $login = strip_tags($login);
        $sql = "SELECT id,login FROM users WHERE login='".$login."'";
        $result = $this->db->query($sql);
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
         return $row['id'];
      }

      public function countRoomUser($id){
        $id = (int)$id;
        $sql = "SELECT COUNT (userid) FROM room WHERE userid = $id";
        $result = $this->db->query($sql);
        $row = $result->fetchArray(SQLITE3_NUM);
// тут треба рішити проблему з переводом масива в числовий а не асоцеативний
         return $row[0];
        
     }  

     public function LogToId($id){
        $sql = "SELECT id,login FROM users WHERE id=$id";
        $result = $this->db->query($sql) or die($this->db->lastError());
        $row = $result->fetchArray(SQLITE3_ASSOC);
        
        return $row['login'];
    }
    public function countRoomUserId(){
        $sql = "SELECT id,userid,title,description FROM room";
        $result = $this->db->query($sql) or die($this->db->lastError());
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            print $row['userid'];
        }
    }
    public function countRoomTitleandDescription(){
        $sql = "SELECT id,userid,title,description FROM room";
        $result = $this->db->query($sql) or die($this->db->lastError());
        echo "<table class='tt' border=1 width=100%><tr><th>номер</th>
              <th>автор</th><th>заголовок</th><th>описание</th>
              <th>вход</th></tr>";
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
          echo "<tr><td>{$row['id']}</td><td>{$this->LogToId($row['userid'])}</td>
               <td>{$row['title']}</td><td>{$row['description']}</td>
               <td><a href='http://chat/chat.php?user=".$_SESSION['user']['login']."'>вход</a>
                   </td></tr>";  
        }
              
        echo "</table>";
    }

    public function getMessage(){
        $sql = "SELECT message.userid,message.roomid,message.messages,message.date,
                       users.id,users.login FROM message,users 
                       WHERE message.roomid =".$_SESSION['id_room']." AND users.id = message.userid";
        $result = $this->db->query($sql);
        echo "<div style='padding: 15px;'>"; 
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
           echo "<p>".date('H:i:s',$row['message.date'])."\n<b>".
                $row['users.login'].":</b>\n".$row['message.messages'];
           echo "</p>";
        }
        echo "</div>";
    }
 
}

?>