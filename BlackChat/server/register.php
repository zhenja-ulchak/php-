<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="content-type" content="text/html; charset=windows-1251"><link href="register.css" rel="stylesheet" type="text/css"><title>����������� ������ ������������</title></head><body onload="regf.user.focus()">
<table border="0" cellspacing="0" cellpadding="5" align="center" class="txt">
<?

include("general.php"); chdir("../");

$ERM = ""; $RFR = true;

if (!ReadIni(4)) {
 echo '<tr><td><h2 align="center">����������� ����� ������������� � ������ ������ �� ��������!</h1></td></tr>'; $RFR = false;
}

if (isset($_REQUEST['user'])&&ReadIni(4)) {
 $user = $_REQUEST['user']; $name = $_REQUEST['name']; $surn = $_REQUEST['surn']; $gmal = $_REQUEST['gmal']; $pmal = $_REQUEST['pmal']; $fpas = $_REQUEST['fpas']; $lpas = $_REQUEST['lpas']; $info = $_REQUEST['info']; $dadt = $_REQUEST['dadt']; $mndt = $_REQUEST['mndt']; $yrdt = $_REQUEST['yrdt'];
 $user = Pms($user); $name = Pms($name); $surn = Pms($surn); $fpas = Dsp($fpas); $lpas = Dsp($lpas); $info = Pms($info,false); $gmal = Dsp(strtolower($gmal)); $pmal = Dsp(strtolower($pmal));
 if (!$user||!isset($_REQUEST['usex'])||!$pmal||!$fpas||!$lpas||!$dadt||!$mndt||!$yrdt||($dadt === '�����')||($mndt === '�����')||($yrdt === '���')) {
  $ERM = '��������� �� ��� ������������ ����';
 }
 elseif ((strlen($user) > 20)||(strlen($user) < 3)) {
  $ERM = '��� ����� ������������ �����';
 }
 elseif (ErrChr($user)) {
  $ERM = '������� '.$GLOBALS['ERC'].' �� ��������� � ����';
 }
 elseif (strlen(NosmName($user)) < 3) {
  $ERM = '��� �� ������������� �������';
 }
 elseif (CheckWords($user)) {
  $ERM = '��� �������� �������� ������������� �������';
 }
 elseif (InfUreg($user)) {
  $ERM = '������������ � ������� ����� ��� ��������������� � ����';
 }
 elseif (strlen($name) > 20) {
  $ERM = '��� ����� ������������ �����';
 } 
 elseif (CheckWords($name)) {
  $ERM = '��� �������� �������� ������������� �������';
 }
 elseif (ErrChr($name)) {
  $ERM = '��� �������� ������������ �������';
 }
 elseif (strlen($surn) > 20) {
  $ERM = '������� ����� ������������ �����';
 }
 elseif (CheckWords($surn)) {
  $ERM = '������� �������� �������� ������������� �������';
 }
 elseif (ErrChr($surn)) {
  $ERM = '������� �������� ������������ �������';
 }
 elseif (strlen($gmal)&&(!strchr($gmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($gmal) < 7)||CheckMail($gmal)||(strlen($pmal) > 25))) {
  $ERM = '����� email ����� ������ �������';
 }
 elseif (!strchr($pmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($pmal) < 7)||CheckMail($pmal)||(strlen($pmal) > 25)) {
  $ERM = 'email ����� ��� �������������� ������ ������ �������';
 }
 elseif ($fpas !== $lpas) {
  $ERM = '������ �� ���������'; 
 }
 elseif (strlen($fpas) < 8) {
  $ERM = '�������� ����� ������, ������ ������ ���� �� ����� 8 ��������';
 }
 elseif (strlen($info) > 1000) {
  $ERM = '����� �������������� ���������� ������� �������';
 }
 elseif (CheckSpace($info)) {
  $ERM = '����� �������������� ���������� �������� ������� ������� �����';
 }
 elseif (CheckWords($info)) {
  $ERM = '����� �������������� ���������� �������� ������������� �������';
 }
 elseif ($Mas = GetAusr()) {
  foreach ($Mas as $V) {
   $V = GetUser($V); if (CompName($V[0],$user)) $ERM = '������������ � ������� ����� ��� ��������� � ����';
  }
 }
 if (!$ERM) {
  $P = 1; if (!file_exists($RSDR.$REGF)) $P = 3; $RFR = false;
  if ($F = fopen($RSDR.$REGF,'ab')) {
   $T = array_reverse(explode(" ",microtime())); $T[1] = substr($T[1],2); $T[2] = implode("",$T).mt_rand(111,999); fwrite($F,$user."\t".$T[2]."\n"); fclose($F);
   $F = fopen($RSDR.$PRUS.$T[2],'wb'); fwrite($F,$fpas."\t".$pmal."\t".$T[0]."\t0\t".$P."\t".$name."\t".$surn."\t".$_REQUEST['usex']."\t".GetDfn($dadt,$mndt,$yrdt)."\t".$gmal."\t0\t0\t0\t0\t".Ddn($info)); fclose($F);
   echo '<tr><td colspan="2" width="100%" height="100%" align="center" valign="middle"><font class="grn">����������� ������ �������!</font><br><br><a href="../index.php" class="txt">�������� �� �������</a><br><br><a href="javascript:logf.submit()" class="txt">����� � ���</a></td></tr>
   <form action="../index.php" method="post" name="logf"><input type="hidden" name="l" value="'.$user.'"><input type="hidden" name="p" value="'.$fpas.'"><input type="hidden" name="j" value="1"></form>';
   if (ReadIni(3)) WRL('+ [SERVER] ����������� ������ ������������ ['.$user.'] ������ �������!');
  } else $ERM = '����������� ����������� ��������, ���������� �����';
 }
}

// ������ �����: 1 - ������, 2 - ����� ��� ������, 3 - ���� �����������, 4 - ���� ���������� �����, 5 - ����������, 6 - ���, 7 - �������, 8 - ���, 9 - ���� ��������, 10 - ����� �����, 11 - ����������������� ���������� ������, 12 - ������������ ��� ���������� ������������, 13, 14 - ����������������� ����, 15 - ���������� � ������������.

if ($ERM) echo '<tr><td colspan="5"><font class="erc">������: '.$ERM.'!</font><br><br></td></tr>';

if ($RFR) {

echo '<form action="register.php" method="post" name="regf"><tr><td width="140">���:</td><td width="200"><input type="text" name="user" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($user).'"></td><td><font class="grn">*</font></td><td width="20" rowspan="14"></td><td rowspan="14" width="300" valign="top">���� ���������� �������� <font class="grn">*</font> �������� �������������.<br><br>�������������� ���������� � ��� �� ������ ��������� 1000 ��������.<br><br>E-Mail ����� � ���� "����� E-mail" ����� �������� ���� ������������������ � ���� �������������.<br><br>� ���� "E-mail ��� ������" ���������� ������ E-mail ����� �� ������� ����� ��������� ��� ������, ���� �� ����� ��� ��������.<br><br>����� ������ ������ ���� �� ����� 8 ��������.<br><br>��� ���� ���������� ����� �������� ������ ������������������ �������������.</td></tr>
<tr><td>���:</td><td><input type="text" name="name" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($name).'"></td><td></td></tr>
<tr><td>�������:</td><td><input type="text" name="surn" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($surn).'"></td><td></td></tr>
<tr><td>���� ��������:</td><td><select name="dadt" class="frm"><option>�����</option>'.DaList($_REQUEST['dadt']).'</select>&nbsp;&nbsp;&nbsp;<select name="mndt" class="frm"><option>�����</option>'.MnList($_REQUEST['mndt']).'</select>&nbsp;&nbsp;&nbsp;<select name="yrdt" class="frm"><option>���</option>'.YrList($_REQUEST['yrdt']).'</select></td><td><font class="grn">*</font></td></tr>
<tr><td>���:</td><td>�&nbsp;<input type="radio" name="usex" value="0" class="chk"'.(!$_REQUEST['usex'] ? ' checked' : '').'>&nbsp;&nbsp;&nbsp;�&nbsp;<input type="radio" name="usex" value="1" class="chk"'.($_REQUEST['usex'] ? ' checked' : '').'></td><td></td></tr>
<tr><td>����� E-mail:</td><td><input type="text" name="gmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($gmal).'"></td><td></td></tr>
<tr><td>E-mail ��� ������:</td><td><input type="text" name="pmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($pmal).'"></td><td><font class="grn">*</font></td></tr>
<tr><td colspan="3"><br></td></tr>
<tr><td>������:</td><td><input type="password" name="fpas" size="33" maxlength="20" class="frm"></td><td><font class="grn">*</font></td></tr>
<tr><td>�������������:</td><td><input type="password" name="lpas" size="33" maxlength="20" class="frm"></td><td><font class="grn">*</font></td></tr>
<tr><td colspan="3"><br></td></tr>
<tr><td colspan="2">�������������� ���������� � ���:<br><br><textarea style="width: 100%" rows="6" name="info" class="frm">'.htmlspecialchars($info).'</textarea></td><td></td></tr>
<tr><td colspan="3"><br></td></tr>
<tr><td><input type="button" value="�� �������" class="but" onclick="top.location.href = \'../index.php\'"></td><td align="right"><input type="submit" value="������������������!" class="but"></td><td></td></tr>
</form>';

}

?>
</table></body></html>