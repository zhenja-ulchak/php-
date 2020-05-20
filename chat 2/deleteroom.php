<?php
require_once 'config.php';
$select = new select();
$delete = new delete();
$templater = new templater();
if(!$_SESSION['user']['login']) header("Location:index.php");
if($_GET['delroom']){
    $artid = $_GET['delroom']?(int)$_GET['delroom']:NULL;
    if(!$delete->deleteroom($artid)) die('Ошибка при удалении');
    else echo "Комната чата успешно удалена";
}
$title = "Удаление комнат чата";
print $templater->tmp($title,'header.tpl');
$id = $select->LoginToId($_SESSION['user']['login']);
print $select->DeleteRoomTitleandDescription($id);
print $templater->tmp($title,'footer.tpl');
?>
