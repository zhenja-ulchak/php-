<?php
require_once 'config.php';
$insert = new insert();
$select = new select();
if($_POST){
 $message = strip_tags($_POST['message']);
 $us_id = $select->LoginToId($_SESSION['user']['login']);
 $id_room = $_SESSION['id_room']; //id �������
 $insert->getMessage($id_room,$message,$us_id);
}
echo "�� ����� ���:".$_SESSION['user']['login'];
?>
<div class="chat">
    <form method="post">
       <center><h2>���������</h2><br />
           <textarea name="message" rows=4 cols=40 wrap="off"></textarea><br />
           <input type="submit" value="���������" />
    </form> 
 
</div>
