<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="content-type" content="text/html; charset=windows-1251"><title>�������������� ������</title><link href="reminder.css" rel="stylesheet" type="text/css"></head><body onload="regf.rlog.focus()">
<table border="0" align="center" height="100%"><tr><td align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="5" align="center" class="txt">
<?

include('general.php'); chdir("../");

$SRF = false; $ERM = "";

if (strlen($_REQUEST['rlog'])&&strlen($_REQUEST['reml'])) {
 if (($Mas = InfUreg(Pms($_REQUEST['rlog'])))&&(strlen($Mas[0]) == strlen(Pms($_REQUEST['rlog'])))) {
  if (strtolower(Dsp($_REQUEST['reml'])) === $Mas[2]) $SRF = $Mas; else $ERM = '�������� Email �����';
 } else $ERM = '������� ��������� ��� ����� � Email �����, ����� ���� ��������� �������';
}

if ($SRF) {
$Headr = "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=Windows-1251\r\nContent-Transfer-Encoding: base64\r\nFrom: BLACK CHAT <".$EMAIL.">\r\n";
if (@mail($SRF[2],"�������������� ������",base64_encode("������������ ".($SRF[6] ? $SRF[6]." ".$SRF[7] : $SRF[0])."!\r\n\r\n���������� ��� �� ������������� ������ �������������� ������.\r\n\r\n��� ����� � ��� ��� ������� \"".$SRF[0]."\" ����������� ��������� ������: ".$SRF[1]."\r\n\r\n�� ���� �������� ������ �� ���� �����: ".$EMAIL.".\r\n\r\nhttp://".$_SERVER['SERVER_NAME']." - ��� ��������� ��� �������� �������;-)"),$Headr))
 echo '<tr><td align="center">�������'.($SRF[8] ? "��" : "��").' <font class="grn">'.$SRF[0].'</font><br><br>������ ��� ����� � ��� ��� ��������� ��� �� �����: <font class="grn">'.$SRF[2].'</font>.<br><br><a href="../index.php" class="txt">�������� �� �������</a></td></tr>';
else
 echo '<tr><td align="center">�������'.($SRF[8] ? "��" : "��").' <font class="grn">'.$SRF[0].'</font><br><br><font class="erc">������ ��� ����� � ��� �� ��� ��������� ��� ��-�� ���� �� �������, ���������� ����� ��������������� ������ �������.</font><br><br>��� ������ �� ���� �����: <a href="mailto:'.$EMAIL.'" class="txt">'.$EMAIL.'</a><br><br><a href="../index.php" class="txt">�������� �� �������</a></td></tr>';
} else {
 echo '<form action="reminder.php" method="post" name="regf"><tr><td colspan="2" align="center">'.($ERM ? '<font class="erc">'.$ERM.'!</font>' : '������� ��� ����� � �mail �����<br>������� �� ������� ��� ����������� � ����.').'<br><br></td></tr><tr><td><table border="0" cellspacing="0" cellpadding="5" align="center" class="txt" width="300"><tr><td width="50">�����:</td><td><input type="text" name="rlog" size="33" maxlength="20" class="frm" value="'.$_REQUEST['rlog'].'"></td></tr><tr><td>Email:</td><td><input type="text" name="reml" size="33" maxlength="25" class="frm" value="'.$_REQUEST['reml'].'"></td></tr><tr><td colspan="2" align="center"><br><br><input type="submit" value="���������!" class="but"></td></tr><tr><td colspan="2" align="center"><br><br><a href="../index.php" class="txt">�������� �� �������</a></td></tr></table></td></tr></form>';
}

?>
</table></td></tr></table></body></html>