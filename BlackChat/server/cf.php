<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<html><head><link href="config.css" rel="stylesheet" type="text/css"></head><body>
<table border="0" cellspacing="0" cellpadding="0" align="center" class="txt" width="100%"><form action="cf.php" method="post" target="CU"><tr valign="top"><td align="center">
<?

include("general.php"); chdir("../");

// ���������� �������� ����� 

function ShowInfo($U)
{global $Month;
 if ($U = InfUreg($U)) { $D = explode(".",$U[9]); $D[0] = (integer) $D[0]; $D[1] = $Month[$D[1]-1]; $A = CheckAusr($U[0]);
  $S = '<table border="0" cellspacing="0" cellpadding="3" align="center" class="txt"><tr><td width="140">���:</td><td width="200"><font class="yel">'.htmlspecialchars($U[0]).'</font></td><td></td></tr>
  <tr><td>�����:</td><td><font class="grn">'.InfPrv($U[5]).'</font></td><td></td></tr>
  <tr><td>���� �����������:</td><td><font class="grc">'.date("d.m.Y [H:i]",$U[3]).'</font></td><td></td></tr>
  <tr><td>��������� ����:</td><td><font class="grc">'.($U[4] ? date("d.m.Y [H:i]",$U[4]) : ($A ? '� ������ ���!' : '��� �� �������...')).'</font></td><td></td></tr>
  <tr><td>�����������������:</td><td><font class="grc">'.($U[11] ? GetTime($U[11]) : '�� ��������...').'</font></td><td></td></tr>
  <tr><td>������� ����������:</td><td>'.($A ? '<font class="aqc">'.GetTime(time()-$A[2]).'</font>' : '<font class="grc">���</font>').'</td><td></td></tr>
  <tr><td>���:</td><td><input type="text" name="name" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[6]).'"></td><td></td></tr>
  <tr><td>�������:</td><td><input type="text" name="surn" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[7]).'"></td><td></td></tr>
  <tr><td>���� ��������:</td><td><select name="dadt" class="frm"><option>�����</option>'.DaList($D[0]).'</select>&nbsp;&nbsp;&nbsp;<select name="mndt" class="frm"><option>�����</option>'.MnList($D[1]).'</select>&nbsp;&nbsp;&nbsp;<select name="yrdt" class="frm"><option>���</option>'.YrList($D[2]).'</select></td><td><font class="grn">*</font></td></tr>
  <tr><td>���:</td><td>�&nbsp;<input type="radio" name="usex" value="0" class="chk"'.(!$U[8] ? ' checked' : '').'>&nbsp;&nbsp;&nbsp;�&nbsp;<input type="radio" name="usex" value="1" class="chk"'.($U[8] ? ' checked' : '').'></td><td></td></tr>
  <tr><td>����� E-mail:</td><td><input type="text" name="gmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($U[10]).'"></td><td></td></tr>
  <tr><td>E-mail ��� ������:</td><td><input type="text" name="pmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($U[2]).'"></td><td><font class="grn">*</font></td></tr>
  <tr><td colspan="3"><br></td></tr>
  <tr><td>������:</td><td><input type="text" name="fpas" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[1]).'"></td><td><font class="grn">*</font></td></tr>
  <tr><td>�������������:</td><td><input type="password" name="lpas" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[1]).'"></td><td><font class="grn">*</font></td></tr>';
  if (($U[0] !== $_SESSION['user'])&&PrevUser()) {
   $S .= '<tr><td colspan="3"><br></td></tr><tr><td>����������:</td><td><input type="checkbox" name="busr" class="chk"'.($U[12] ? ' checked' : '').'></td><td></td></tr>';
   if ($_SESSION['prev'] == 3) $S .= '<tr><td>�������������:</td><td><input type="checkbox" name="prev" class="chk"'.(($U[5] > 1) ? ' checked' : '').'></td><td></td></tr>';
  }
  $S .= '<tr><td colspan="3"><br></td></tr><tr><td colspan="2">�������������� ����������:<br><br><textarea style="width: 100%" rows="6" name="info" class="frm">'.htmlspecialchars($U[15]).'</textarea></td><td></td></tr>
  <tr><td colspan="3"><br></td></tr><tr><td><script>function Del(F) {if (confirm("�����?")) { F.c.value="deluser"; F.submit(); } }</script><input type="button" class="but" onclick="Del(this.form)" value="������� �������"></td><td align="right"><input type="submit" class="but" value="���������"></td><td></td></tr><input type="hidden" name="user" value="'.$U[0].'"><input type="hidden" name="c" value="upduser"></table>';
  echo $S;
 }
}

// ���������� ���������� 

function PrevUser()
{
 if ($U = InfUreg($_REQUEST['user'])) {
  if ($_SESSION['prev'] > $U[5]) return true; else return false;
 } else return false;
}

// ������� ������������ ����� �� ��� ����� 

function DelBan($U)
{global $RSDR,$BNLF;
 if (file_exists($RSDR.$BNLF)&&filesize($RSDR.$BNLF)) {
  $Mas = explode("\n",trim(file_get_contents($RSDR.$BNLF))); $F = fopen($RSDR.$BNLF,'wb');
  foreach ($Mas as $V) {
   $I = explode("\t",$V); if (!CompName($I[0],$U)) fwrite($F,$V."\n");
  }
  fclose($F);
 }
}

// ��������� ������� ����� 

function UpdUser()
{$user = $_REQUEST['user']; $name = $_REQUEST['name']; $surn = $_REQUEST['surn']; $gmal = $_REQUEST['gmal']; $pmal = $_REQUEST['pmal']; $fpas = $_REQUEST['fpas']; $lpas = $_REQUEST['lpas']; $info = $_REQUEST['info']; $dadt = $_REQUEST['dadt']; $mndt = $_REQUEST['mndt']; $yrdt = $_REQUEST['yrdt'];
 $user = Pms($user); $name = Pms($name); $surn = Pms($surn); $fpas = Dsp($fpas); $lpas = Dsp($lpas); $info = Pms($info,false); $gmal = Dsp(strtolower($gmal)); $pmal = Dsp(strtolower($pmal));
 if (!isset($_REQUEST['usex'])||!$pmal||!$fpas||!$lpas||!$dadt||!$mndt||!$yrdt||($dadt === '�����')||($mndt === '�����')||($yrdt === '���')) {
  return 'red">������: ��������� �� ��� ������������ ����!';
 }
 elseif (strlen($name) > 20) {
  return 'red">������: ��� ����� ������������ �����!';
 }
 elseif (CheckWords($name)) {
  return 'red">������: ��� �������� �������� ������������� �������!';
 }
 elseif (ErrChr($name)) {
  return 'red">������: ��� �������� ������������ �������!';
 }
 elseif (strlen($surn) > 20) {
  return 'red">������: ������� ����� ������������ �����!';
 }
 elseif (CheckWords($surn)) {
  return 'red">������: ������� �������� �������� ������������� �������!';
 }
 elseif (ErrChr($surn)) {
  return 'red">������: ������� �������� ������������ �������!';
 }
 elseif (strlen($gmal)&&(!strchr($gmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($gmal) < 7)||CheckMail($gmal)||(strlen($pmal) > 25))) {
  return 'red">������: ����� email ����� ������ �������!';
 }
 elseif (!strchr($pmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($pmal) < 7)||CheckMail($pmal)||(strlen($pmal) > 25)) {
  return 'red">������: email ����� ��� ������ ������ �������!';
 }
 elseif ($fpas !== $lpas) {
  return 'red">������: ������ �� ���������!';
 }
 elseif (strlen($fpas) < 8) {
  return 'red">������: �������� ����� ������, ������ ������ ���� �� ����� 8 ��������!';
 }
 elseif (strlen($info) > 1000) {
  return 'red">������: ����� �������������� ���������� ������� �������!';
 }
 elseif (CheckSpace($info)) {
  return 'red">������: ����� �������������� ���������� �������� ������� ������� �����!';
 }
 elseif (CheckWords($info)) {
  return 'red">������: ����� �������������� ���������� �������� ������������� �������!';
 }
 else {
  if ($U = InfUreg($user)) {
   $U[1] = $fpas; $U[2] = $pmal; $U[6] = $name; $U[7] = $surn; $U[8] = $_REQUEST['usex']; $U[9] = GetDfn($dadt,$mndt,$yrdt); $U[10] = $gmal; $U[15] = Ddn($info);
   if ($_SESSION['prev'] > $U[5]) {
    if (($_SESSION['prev'] == 3)&&((array_key_exists('prev',$_REQUEST)&&($U[5] == 1))||($U[5] == 2))) {
	 if (array_key_exists('prev',$_REQUEST)) $U[5] = 2; else $U[5] = 1;
	}
    if ((array_key_exists('busr',$_REQUEST)&&($U[12] == 0))||($U[12] == 1)) {
     if (array_key_exists('busr',$_REQUEST)) $U[12] = 1; else $U[12] = 0;
    }
   }
   UpdUreg($U); return 'grn">������ ���������!';
  } else return 'red">������������ "'.$_REQUEST['user'].'" � ���� �� ���������!';
 }
}

// ������� ������ ���������� ������ ���� ��� ����... 

function GetBanList()
{global $RSDR,$BNLF; ChkBan(); clearstatcache(); $S = "";
 if (file_exists($RSDR.$BNLF)&&filesize($RSDR.$BNLF)) {
  $Mas = explode("\n",trim(file_get_contents($RSDR.$BNLF)));
  $S .= '<table border="0" cellspacing="0" cellpadding="3" align="center" class="txt" width="500"><tr align="center"><td colspan="3">';
  $S .= '����� ����������: <font class="aqc">'.count($Mas).'</font> &nbsp; ������� ����: <font class="grn">'.date("Y.m.d [H:i]").'</font><br><br></td></tr>';
  $S .= '<tr><td colspan="3" align="center"><a href="cf.php?c=clearban" class="grc" target="CU" onclick="return Dbn()">�������� ���� ���-����?</a><br><br><script>function Dbn() { if (confirm("������� ���� ����������?")) return true; else return false; }</script></td></tr>';
  foreach ($Mas as $V) { $S .= '<tr align="center">';
   $I = explode("\t",$V); if ($I[1] === "0.0.0.0") {
    $S .= '<td align="right" width="230"><a href="cf.php?delban='.rawurlencode($I[0]).'" class="txt" target="CU">'.$I[0].'</a></td><td width="150"><font class="red" title="��������: '.TmlInf($I[2]).'.">'.date("Y.m.d [H:i]",$I[2]).'</td><td width="120" align="left"></td></font>';
   } else {
    $S .= '<td align="right" width="230"><a href="cf.php?delban='.rawurlencode($I[0]).'" class="aqc" target="CU">'.$I[0].'</a></td><td width="150"><font class="red" title="��������: '.TmlInf($I[2]).'.">'.date("Y.m.d [H:i]",$I[2]).'</td><td width="120" align="left">'.$I[1].'</td></font>';
   }
   $S .= '</tr>';
  }
  $S .= '</table>';
 }
 return $S;
}

// ��� �������� ������������ �� ���� ������� ��� �������� ������� 

function UsrActDel()
{if ($U = GetSusr($_REQUEST['user'])) { $N = GetName($U); UsrDel($U);
  WRM('U~~~S~: ����������� ������������ ~'.$N.'~ ���� ������ �� ���� � �� �������� ���...',false);
  if (ReadIni(3)) WRL('- [SERVER] ����������� ������������ ['.$N.'] ���� ������ �� ���� � �� �������� ���...');
 }
}

// ������� ������ � ������� ���������, ���� ��� ����... 

function GetLogFile()
{global $USDR,$LOGF;
 if (file_exists($USDR.$LOGF)&&filesize($USDR.$LOGF)) {
  return '������ ���� � ������: <font class="grn">'.filesize($USDR.$LOGF).'</font> &nbsp;&nbsp;&nbsp; <a href="cf.php?c=viewlog" class="txt" target="_blank">��������</a> &nbsp;&nbsp;&nbsp; <a href="cf.php?c=clearlog" class="grc" target="CU" onclick="return confirm(\'� ������?\')">��������</a>';
 }
}

session_start(); $I = session_get_cookie_params(); session_set_cookie_params(0,$I['path'],$I['domain'],true); $U = false;

if (array_key_exists('prev',$_SESSION)&&$_SESSION['prev']) {

  if (array_key_exists('user',$_REQUEST)&&array_key_exists('c',$_REQUEST)) {
   if (($_REQUEST['c'] === 'deluser')&&PrevUser()) {
    UsrActDel(); if (DelUreg($_REQUEST['user'])) echo '<font class="grn">������������ "'.$_REQUEST['user'].'" ��� ����� �� ����!</font><br><br>'; else '<font class="red">������������ "'.$_REQUEST['user'].'" � ���� �� ������!</font><br><br>'; if ($_SESSION['prev'] > 1) $_REQUEST['user'] = ""; else $_REQUEST['user'] = $_SESSION['user'];
   } elseif (($_REQUEST['c'] === 'deluser')&&($_REQUEST['user'] === $_SESSION['user'])&&($_SESSION['prev'] < 3)) {
    UsrActDel(); DelUreg($_REQUEST['user']); echo '<script>alert("���� ������ ���� ��������� �������!")</script>';
   } elseif ((PrevUser()||($_REQUEST['user'] === $_SESSION['user']))&&($_REQUEST['c'] === 'upduser')) echo '<font class="'.UpdUser().'</font><br><br>';
   ChkUreg();
  }

  if ($_SESSION['prev'] > 1) {
   if (array_key_exists('config',$_REQUEST)) {
    if (UpdateIni(array((array_key_exists('chatg',$_REQUEST) ? 1 : 0),(array_key_exists('chatc',$_REQUEST) ? 1 : 0),(array_key_exists('chatl',$_REQUEST) ? 1 : 0),(array_key_exists('chatr',$_REQUEST) ? 1 : 0),(array_key_exists('chatn',$_REQUEST) ? 1 : 0),(array_key_exists('chatf',$_REQUEST) ? 1 : 0),(array_key_exists('chatd',$_REQUEST) ? 1 : 0)))) echo '<font class="grn">��������� ���������!</font><br><br>'; else echo '<font class="red">�� ������� ��������� ���������!</font><br><br>';
   }
   if (array_key_exists('delban',$_REQUEST)) {
    DelBan($_REQUEST['delban']);
   }
   if (array_key_exists('c',$_REQUEST)) {
    if ($_REQUEST['c'] === 'clearban') {
     if (file_exists($RSDR.$BNLF)&&filesize($RSDR.$BNLF)) unlink($RSDR.$BNLF);
    }
    if ($_REQUEST['c'] === 'viewlog') {
     if (file_exists($USDR.$LOGF)&&filesize($USDR.$LOGF)) echo '<html><head><title>BLACK CHAT :: LOG :: '.date("H:i").'</title></head><body><table width="100%" class="txt"><tr><td align="left">'.str_replace("\r\n","<br>",str_replace("[","<font class=\"yel\">{</font>",str_replace("]","<font class=\"yel\">}</font>",htmlspecialchars(file_get_contents($USDR.$LOGF))))).'</td></tr></table></body></html>'; exit();
    }
    if ($_REQUEST['c'] === 'clearlog') {
     if (file_exists($USDR.$LOGF)&&filesize($USDR.$LOGF)) unlink($USDR.$LOGF);
    }
   }
  }

  if (empty($_REQUEST['user'])) {
   if ($_SESSION['prev'] > 1) {
    $_SESSION['cuser'] = ""; ChkIni(); $C = ReadIni(); echo '- <font class="yel">'.$_SESSION['users'].'</font> -<br><table border="0" cellspacing="0" cellpadding="3" align="center" class="txt"><tr><td width="280">�������� ����:</td><td><input type="checkbox" class="chk" name="chatg"'.($C[0] ? ' checked' : '').'></td></tr><tr><td>��������� �������� ��� ����� ������:</td><td><input type="checkbox" class="chk" name="chatc"'.($C[1] ? ' checked' : '').'></td></tr><tr><td>���������� ��� ��������� � ���:</td><td><input type="checkbox" class="chk" name="chatl"'.($C[2] ? ' checked' : '').'></td></tr><tr><td>����������� ����� �������������:</td><td><input type="checkbox" class="chk" name="chatr"'.($C[3] ? ' checked' : '').'></td></tr><tr><td>������������ ������ ������� �������:</td><td><input type="checkbox" class="chk" name="chatd"'.($C[6] ? ' checked' : '').'></td></tr><tr><td>���������� ������������� �������:</td><td><input type="checkbox" class="chk" name="chatn"'.($C[4] ? ' checked' : '').'></td></tr><tr><td>���������� �����:</td><td><input type="checkbox" class="chk" name="chatf"'.($C[5] ? ' checked' : '').'></td></tr><input type="hidden" name="config" value="1"></table><br><br><input type="submit" class="but" value="���������"><script>setTimeout(\'top.CU.location.href="cf.php"\',300000)</script><br><br><br>'.GetLogFile().'<br><br><br>'.GetBanList();
   } else ShowInfo($_SESSION['user']);
  } else {
   if ($_SESSION['prev'] > 1) $_SESSION['cuser'] = $_REQUEST['user'];
   if (PrevUser()||($_REQUEST['user'] === $_SESSION['user'])) ShowInfo($_REQUEST['user']); else ShowInfo($_SESSION['user']);
  }

if ($_SESSION['prev'] > 1) echo '<script>top.UL.location.href="ul.php"</script>';

}

?>
</td></tr></form></table></body></html>