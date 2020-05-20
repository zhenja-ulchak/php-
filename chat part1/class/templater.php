<?php
require_once 'insert.php';
require_once 'select.php';
class templater{
  private $profile;
  private $select; 
  private $title;
  private $path;
  private $row;
  
  public function __construct() {
      $this->select = new select();
  }
  public function showprofile($login){
      try{
          if(!$this->select->profileUser($login))
               throw new Exception("такого пользователя нет");
          else{
              $this->profile = $this->select->profileUser($login);
          }
      }catch(Exception $e){
          die($e->getMessage());
      }
      return TRUE;
  }
  public function tmp($title,$path=NULL){
      $this->title = $title;
      $this->path = $path;
    //   вертаэ id даного метода
      $userid = $this->select->LoginToId($_SESSION['user']['login']);
    // //   
      $count = $this->select->countRoomUser($userid);
      $tmp = file_get_contents(PATH."/temp/".$this->path);
      $tmp = str_replace('{TITLE}',$this->title,$tmp);
      $tmp = str_replace('{PATH}',PATH,$tmp);
      $tmp = str_replace('{LOGIN}',$login = $_SESSION['user']['login']?$_SESSION['user']['login']:false,$tmp);
      $tmp = str_replace('{LOGOUT}','index.php?logout=true',$tmp);
    //   скыльки записей создав юзер
      $tmp = str_replace('{COUNT}',$count,$tmp);
      
      if($this->profile == TRUE){
          $tmp = str_replace('{DATE_REGISTER}',date("d-m-Y {H:i:s}",$this->profile['date']),$tmp);
          $tmp = str_replace('{R_LOGIN}',$this->profile['login'],$tmp);
          $tmp = str_replace('{NAME}',$this->profile['name'],$tmp);
          $tmp = str_replace('{EMAIL}',$this->profile['email'],$tmp);
          $tmp = str_replace('{GENDER}',$this->profile['gender'],$tmp);
          $tmp = str_replace('{AGE}',$this->profile['age'],$tmp);
   
      }else{
          $tmp = str_replace('{DATE_REGISTER}',NULL,$tmp);
          $tmp = str_replace('{R_LOGIN}',NULL,$tmp);
          $tmp = str_replace('{NAME}',NULL,$tmp);
          $tmp = str_replace('{EMAIL}',NULL,$tmp);
          $tmp = str_replace('{GENDER}',NULL,$tmp);
          $tmp = str_replace('{AGE}',NULL,$tmp); 
      }
      return $tmp;

  }
}

?>