<?php
class select{
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
    function getAjax($email){
	$email = strip_tags($email);
	$email = sqlite_escape_string($email);
	try{
	    $sql = "SELECT id,email FROM users WHERE email='$email'";
	    $emailResult = $this->db->query($sql);
	    if(!emailResult)
		 throw new Exception("Error Database".__LINE__);
	    $row = $emailResult->fetch(SQLITE_ASSOC);
	    if($email === $row['email'])
		throw new Exception("Такой email уже используется");
	    else
		throw new Exception("Данный email свободен");
	   }catch(Exception $e){
	       die($e->getMessage());
	   }
    }
    function getEmail($email){
	try{
	    $sql = "SELECT id,email FROM users WHERE email='$email'";
	    $emailResult = $this->db->query($sql);
	    if(!$emailResult)
		 throw new Exception("Error Database".__LINE__);
	    $row = $emailResult->fetch(SQLITE_ASSOC);
	    if($email === $row['email'])
		throw new Exception("Такой email уже используется");
	   }catch(Exception $e){
	       die($e->getMessage());
	   }
    }
    function avto($email,$password){
	try{
	    $sql = $this->db->query("SELECT id,login,email,password FROM users WHERE email='$email'");
	    if(!$sql)
		throw new Exception("Error Database".__LINE__);
	    $row = $sql->fetch(SQLITE_ASSOC);
	    if($row['email'] === $email && $row['password'] === $password){
		$_SESSION['user']['login'] = $row['login'];
		return true;
	    }
	    else die("Данные не совпадают");
	}catch(Exception $e){
	    die($e->getMessage());
	}
    }
    public function profileUser($login){
        $sql = "SELECT id,login,name,email,age,gender,date FROM users
                 WHERE login='".$login."'";
        $result = $this->db->query($sql) or die($this->db->lastError());
        $row = $result->fetch(SQLITE_ASSOC);
        
        return $row;
    }
    public function LoginToId($login){
      $login = strip_tags($login);
      $sql = "SELECT id,login FROM users WHERE login='".$login."'";
      $result = $this->db->query($sql) or die($this->db->lastError());
      $row = $result->fetch(SQLITE_ASSOC);
      
       return $row['id'];
    }
    public function countRoomUser($id){
       $id = (int)$id;
       $sql = "SELECT COUNT (userid) FROM room WHERE userid = $id";
       $result = $this->db->query($sql)or die($this->db->lastError());
       $row = $result->fetch(SQLITE_NUM);
       
        return $row[0];
       
    }
    public function LogToId($id){
        $sql = "SELECT id,login FROM users WHERE id=$id";
        $result = $this->db->query($sql) or die($this->db->lastError());
        $row = $result->fetch(SQLITE_ASSOC);
        
        return $row['login'];
    }
    public function countRoomUserId(){
        $sql = "SELECT id,userid,title,description FROM room";
        $result = $this->db->query($sql) or die($this->db->lastError());
        while($row = $result->fetch(SQLITE_ASSOC)){
            print $row['userid'];
        }
    }
    public function countRoomTitleandDescription(){
        $sql = "SELECT id,userid,title,description FROM room";
        $result = $this->db->query($sql) or die($this->db->lastError());
        echo "<table class='tt' border=1 width=100%><tr><th>Номер</th>
              <th>Автор</th><th>Заголовок</th><th>Описание</th>
              <th>Вход</th></tr>";
        while($row = $result->fetch(SQLITE_ASSOC)){
          echo "<tr><td>{$row['id']}</td><td>{$this->LogToId($row['userid'])}</td>
               <td>{$row['title']}</td><td>{$row['description']}</td>
               <td><a href='http://chat/chat.php?user=".$_SESSION['user']['login']."'>Вход</a>
                   </td></tr>";  
        }
              
        echo "</table>";
    }
    public function getMessage(){
        $sql = "SELECT message.userid,message.roomid,message.messages,message.date,
                       users.id,users.login FROM message,users 
                       WHERE message.roomid =".$_SESSION['id_room']." AND users.id = message.userid";

        $result = $this->db->query($sql) or die($this->db->lastError());
        echo "<div style='padding: 15px;'>";
        while($row = $result->fetch(SQLITE_ASSOC)){
           echo "<p>".date('H:i:s',$row['message.date'])."\n<b>".
                $row['users.login'].":</b>\n".$row['message.messages'];
           echo "</p>";
        }
        echo "</div>";
    }
    public function DeleteRoomTitleandDescription($id){
        $sql = "SELECT id,userid,title,description FROM room WHERE userid=$id";
        $result = $this->db->query($sql) or die($this->db->lastError());
         echo "<table class='tt' border=1 width=100%><tr><th>Номер</th>
              <th>Автор</th><th>Заголовок</th><th>Описание</th>
              <th>Удалить</th></tr>";
         while($row = $result->fetch(SQLITE_ASSOC)){
             echo "<tr><td>{$row['id']}</td><td>{$this->LogToId($row['userid'])}</td>
               <td>{$row['title']}</td><td>{$row['description']}</td>
               <td><a href='http://chat/deleteroom.php?delroom=".$row['id']."'>Удалить</a>
                   </td></tr>";  
         }
         echo "</table>";
    }
    public function getAdmin($login,$password){
      $password = md5($password);
      $sql = "SELECT id,login,password,access FROM users WHERE access = 1";
      $result = $this->db->query($sql) or die($this->db->lastError());
      $row = $result->fetch(SQLITE_ASSOC);
      if($login === $row['login'] && $password === $row['password']){
          return $row['login'];
      }
    }
    public function adminToIdOne(){
      $sql = "SELECT id,login FROM users WHERE id=1";  
      $result = $this->db->query($sql) or die($this->db->lastError());
      $row = $result->fetch(SQLITE_ASSOC);
      
      return $row['login'];
    }
    public function otherRoom(){
      $sql = "SELECT id,userid,title,description FROM room";
        $result = $this->db->query($sql) or die($this->db->lastError());
        echo "<table class='tt' border=1 width=100%><tr><th>Номер</th>
              <th>Автор</th><th>Заголовок</th><th>Описание</th>
              <th>Вход</th><th>Удалить</th></tr>";
        while($row = $result->fetch(SQLITE_ASSOC)){
          echo "<tr><td>{$row['id']}</td><td>{$this->LogToId($row['userid'])}</td>
               <td>{$row['title']}</td><td>{$row['description']}</td>
               <td><a href='http://chat/chat.php?user=".$_SESSION['user']['login']."'>Вход</a>
                </td><td><a href='http://chat/deleteroom.php?delroom=".$row['id']."'>Удалить</a></td></tr>";  
        }
              
        echo "</table>";  
    }
    public function otherUsers(){
        $sql = "SELECT id,login,name,email,age,gender,date FROM users";
        $result = $this->db->query($sql) or die($this->db->lastError());
         echo "<table border='1'><tr><th>id</th><th>логин</th><th>имя</th><th>email</th><th>age</th>
             <th>gender</th><th>дата регистрации</th><th>удалить</th></tr>";
        while($row = $result->fetch(SQLITE_ASSOC)){
       	  echo "
                 <tr><td>{$row['id']}</td><td>{$row['login']}</td>
                 <td>{$row['name']}</td> <td>{$row['email']}</td>
                 <td>{$row['age']}</td><td>{$row['gender']}</td>
                 <td>".date('Y-m-d, H:i:s',$row['date'])."</td>
                 <td><a href='?users_id={$row['id']}'>удалить</a></td>";
       }
        echo "</table>";
    }
}

?>
