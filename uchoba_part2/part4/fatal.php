<?php
function myHand($error){ return "- ��� ��������� ������, ���������� ���������� � ������ �����";}
ob_start('myHand');

notfoundFunction();

?>