<?php
   error_log(err,2,"home/ff/ff.php");
   error_reporting(E_ALL ~E_NOTICE);
  /*set_error_handler('error_handler',E_ALL);
  function error_handler($eerNo,$errStr,$errFile,$errLine){  	if(ob_get_length()) ob_clean();
  	$error_message = "����������� ������:\n".$errNo.
  	                 "�������������� ������:\n".$errStr.
  	                 "� �����:\n".$errFile.
  	                 "� ������\n".$errLine;
   echo $error_message;
   exit;  }  */
  @mysql_close();
?>