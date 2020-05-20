<?php
require_once 'config.php';
header("Refresh: 2");
$select = new select();
$id = $select->LoginToId($_SESSION['user']['login']);
print $select->getMessage();
?>
 