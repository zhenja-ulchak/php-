<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

include("server/general.php");

// ��������� ���������������-�� ������������, ���� �� ��������� ������... 

function CheckUreg($U,$P)
{$R = 0;
 if ($M = GetUreg()) { $C = count($M);
  for ($i = 0; $i < $C; $i++)
  {
   $I = InfUreg($M[$i]);
   if (CompName($I[0],$U)) {
    if (strlen($I[0]) != strlen($U)) {
	 $R = 5;
	} elseif (strlen($P)) {
	 if ($I[1] !== $P) $R = 1;
	} else $R = 2;
	break;
   }
  }
 }
 if (strlen($P)&&($i == $C)) $R = 3; if (isset($I)&&$I[12]&&($i != $C)) $R = 4; return $R;
}

// ������� ��� �������� ������ ������, ���� �� �������� ����������... 

function ClrTmp()
{global $USDR;
 ScnDir(substr($USDR,0,-1));
}

function ScnDir($Dir)
{$D = opendir($Dir);
 while ($F = readdir($D)) if (strpos($F,".") === false) if (is_dir($Dir."/".$F)) ScnDir($Dir."/".$F); else ScanTmp($Dir."/".$F);
 closedir($D);
}

function ScanTmp($F)
{global $LTF;
 if ((time() - filemtime($F)) > $LTF) unlink($F);
}

// ������ �������� ������� ��� ������ ������������ 

function UsrAdd($U,$id)
{global $USDR,$ULDR; $P = 0;
 if ($R = InfUreg($U)) {
  $P = $R[5]; $U = $R[0];
 }
 $F = fopen($USDR.$ULDR.$id,'wb'); fwrite($F,$U."\t".$_SERVER['REMOTE_ADDR']."\t".time()."\t".$P."\t".$_SERVER['HTTP_USER_AGENT']); fclose($F);
 $_SESSION['prev'] = $P;
}

// ��������� ����� ��������� ������� 

function UsrUpd($id)
{global $USDR,$ULDR;
 if (file_exists($USDR.$ULDR.$id)) touch($USDR.$ULDR.$id);
}

// ������� �������� ������� � ������ ���� ������ �������� (������ �����) 

function UsrChk()
{global $USDR,$ULDR,$LTF; $M = GetAusr();
 foreach ($M as $V) {
  if ((time()-filemtime($USDR.$ULDR.$V)) > $LTF) {
   $U = GetName($V); UsrDel($V); WRM('U~~~S~: ��� ������� ~'.$U.'~ �� ������� ������ �����...',false);
   if ($GLOBALS['LF']) WRL('? [SERVER] ��� ������� ['.$U.'] �� ������� ������ �����...');
  }
 }
}

// ��������� � ��� ���� ����� 

function AddBan($id,$T)
{global $RSDR,$BNLF;
 if ($Mas = GetUser($id)) {
  $F = fopen($RSDR.$BNLF,'ab'); fwrite($F,$Mas[0]."\t".(GetPrev($id) ? '0.0.0.0' : $Mas[1])."\t".(time()+($T*60))."\n"); fclose($F);
 }
}

// ���������� ���� �� ���� � ��� ����� 

function GetBan($U,$P)
{global $RSDR,$BNLF;
 if (file_exists($RSDR.$BNLF)&&filesize($RSDR.$BNLF)) {
  $Mas = explode("\n",trim(file_get_contents($RSDR.$BNLF)));
  foreach ($Mas as $V) {
   $I = explode("\t",$V); if (CompName($I[0],$U)||(!$P&&($I[1] === $_SERVER['REMOTE_ADDR']))) return $I[2];
  }
 }
 return false;
}

// ���������� ������������ �� ���� � ������ ���������� 

function SetArrest($id,$U,$M,$T = 60)
{global $USDR,$TSDR; AddBan($id,$T);
 $F = fopen($USDR.$TSDR.$id,'ab'); fwrite($F,'<script>alert("'.$U.': '.addslashes($M).'")</script>'); fclose($F);
}

// ���������� ������� ������ � ������� ��� �� ���� 

function GetArrest($id)
{global $USDR,$TSDR;
 if (file_exists($USDR.$TSDR.$id)&&filesize($USDR.$TSDR.$id)) {
  UsrDel($id); echo file_get_contents($USDR.$TSDR.$id); unlink($USDR.$TSDR.$id); WRM('U',false);
 }
}

// ���������� ������� ������ �������� ������ 

function LdrUsr()
{echo '<script>top.R=';
 $M = GetAusr(); foreach ($M as &$V) $V = GetName($V);
 sort($M); echo '\''.implode("~~",$M).'\'';
 echo '</script>';
}

// �������� ������� ��� �������� ��������� ������ 

function PutAll($User,$S,$id)
{
 WRM('~~~'.$User.'~: '.$S,false,$id);
 if ($GLOBALS['LF']) WRL('['.$User.'] '.$S);
}

function PutPer($User,$Fyou,$Pers,$S,$id,$Fy)
{if (!$Pers) {
  WRM('~~~'.$User.'~F~U~: '.$S,true,$Fy);
  WRM('~~~'.$User.'~F~'.$Fyou.'~: '.$S,false,$Fy,$id);
  if ($GLOBALS['LF']) WRL('['.$User.'] ��� ['.$Fyou.'] '.$S);
 } else {
  WRM('~~~'.$User.'~A~U~: '.$S,true,$Fy);
  if ($GLOBALS['LF']) WRL('['.$User.'] ����� ['.$Fyou.'] '.$S);
 }
}

function PutMes($S,$Fyou,$Pers,$id)
{if (strlen(Dsp($S))) {
  if ($Fy = GetSusr($Fyou)) PutPer($_SESSION['user'],$Fyou,$Pers,$S,$id,$Fy); else PutAll($_SESSION['user'],$S,$id);
 }
}

// ������� ������� ��������� ��������� �� ������� 
// � ��������� � ����� �������� ������ ���������� ��������� �� ������, ����� ���������� ����. 
// ���� ������������ ��������� 10 ��������� ������� � ���������� 3 �������, �� ������ ��������� �������� ��������� ������� ������������ 
// �� ����������� �������� ������� � �������, ������� ����� ������������ (����������� �������� * 3) ���� �������� ����������. 
// ���� �������� ���������� (3 ���� ��� ������ � 6 ��� ��� ��������� �������������) �� ������ 
// ���������� ����� �� ���� �� 1 ���. ���������� �������� ������������ ����� 1 ���, ��� ������� ��� �� ���� ����� �� ��� �����. 
// ����� ����������� ��������� �� ���������� ������������� �������, ���� ��� ����, �� ��������� ����������� 
// ��� ��� �������� ����� ��������� � ���������� ����. ������ �������� ��������� ������ ��� ������������� � ������ 

function MesPut($id,$mess,$fyou,$pers)
{
 if (($_SESSION['prev'] < 2)&&ReadIni(5)&&(CheckWords($mess))) {
  $mess = ""; WRM('~~~S~F~U~: ���� ��������� �� ���� �����������, ���-��� ��������� ������������� �������!',true,$id);
 }
 if ($_SESSION['mess'] < 10) {
  PutMes($mess,$fyou,$pers,$id);
  if (($_SESSION['prev'] < 2)&&ReadIni(6)) {
   if ((time() - $_SESSION['time']) <= 3) $_SESSION['mess']++; else $_SESSION['mess'] = 0;
   $_SESSION['time'] = time();
  }
 } elseif ($_SESSION['mess'] == 10) {
  if ((time() - $_SESSION['lerr']) >=  3600) $_SESSION['cerr'] = 1; else $_SESSION['cerr']++;
  $_SESSION['mess']++; $_SESSION['lerr'] = time(); if ($_SESSION['cerr'] < (($_SESSION['prev']+1)*3)) WRSE($id);
 }
 echo '<script>top.R=2</script>';
}

// ������� ������� ��� �������� ��������� ������� 

function GMS($id)
{global $USDR; echo '<script>top.R='; if (file_exists($USDR.$id)) rename($USDR.$id,$USDR.$id.".tmp");
 if (file_exists($USDR.$id.".tmp")&&filesize($USDR.$id.".tmp")) {
  echo '\''.file_get_contents($USDR.$id.".tmp").'\''; unlink($USDR.$id.".tmp");
 } else echo '1'; echo ';top.WF.HMS[0]='.date("G").';top.WF.HMS[1]='.(integer) date("i").';top.WF.HMS[2]='.(integer) date("s").';</script>';
}

// ���������� ������ ��������� 

function MesGet($id)
{UsrChk(); UsrUpd($id);
 if (($_SESSION['mess'] > 10)&&((time() - $_SESSION['time']) > (($_SESSION['cerr']*3)*60))) {
  WRSD($id); $_SESSION['mess'] = 0;
 }
 if ($_SESSION['cerr'] == (($_SESSION['prev']+1)*3)) BNSE($id);
 GMS($id);
}

// ������ ����� ������ 

function BNSE($id)
{
 WRM('~~~S~F~U~: �� ������ ��������� ������ ���� �� ����!',true,$id);
 WRM('~~~S~: ������������ ~'.$_SESSION['user'].'~ ����� �� ���� �� 1 ���, �� ������� ������� ���������...',false,$id);
 if ($GLOBALS['LF']) WRL('^ [SERVER] ������������ ['.$_SESSION['user'].'] ����� �� ���� �� 1 ���, �� ������� ������� ���������...');
 SetArrest($id,'SERVER','������ ���������!');
}

// ��������� ����� ���� �� ������ 

function WRSE($id)
{AddBan($id,$_SESSION['cerr']*3);
 WRM('F~~~S~F~U~: ������ ������� ���� �����, ������� '.($_SESSION['cerr']*3).' ���;-)',true,$id);
 WRM('~~~S~: �� ���� ~'.$_SESSION['user'].'~ ����� ������� '.($_SESSION['cerr']*3).' ���!',false,$id);
 if ($GLOBALS['LF']) WRL('% [SERVER] �� ���� ['.$_SESSION['user'].'] ����� ������� '.($_SESSION['cerr']*3).' ���!');
}

// ������� ������ 

function WRSD($id)
{ChkBan();
 WRM('A~~~S~F~U~: ������ ������ �������������...',true,$id);
 WRM('~~~S~: ������ ~'.$_SESSION['user'].'~ ����� �������������, ����� ��������� �������...',false,$id);
 if ($GLOBALS['LF']) WRL('~ [SERVER] ������ ['.$_SESSION['user'].'] ����� �������������, ����� �������� �������...');
}

// ������� ������������ �� ���� �� ������ ����� 

function AdmBan($id,$U,$M,$T)
{$N = $_SESSION['user'];
 if ($I = GetSusr($U)) {
  if ($_SESSION['prev'] > GetPrev($I)) {
   $T = explode("~",$T); if (strlen(Dsp($M)) < 3) $M = '�� ��������...';
   switch ($T[1]) {
    case 1 : $T[2] = $T[0]; $T[1] = '�����'; break;
    case 2 : $T[2] = $T[0]*60; $T[1] = '�����'; break;
    case 3 : $T[2] = ($T[0]*60)*24; $T[1] = '����'; break;
    } SetArrest($I,$N,$M,$T[2]);
   WRM('~~~S~: ~'.$N.'~ ������ ���� �� ���� �� '.$T[0].' '.$T[1].'! �������: '.$M,true,$I);
   WRM('~~~S~: ~'.$N.'~ ������ ~'.$U.'~ �� ���� �� '.$T[0].' '.$T[1].'! �������: '.$M,false,$I,$id);
   WRM('~~~S~: �� ���� ����� ~'.$U.'~ �� '.$T[0].' '.$T[1].'!',true,$id);
   if ($GLOBALS['LF']) WRL('['.$N.'] ������ ['.$U.'] �� ���� �� '.$T[0].' '.$T[1].'! �������: '.$M);
  } else {
   WRM('~~~S~: ~'.$N.'~ ����� ���� ������� �� ����...',true,$I);
   WRM('~~~S~: ������������ ~'.$U.'~ ���������� ������� �� ����, �.�. � ��� ���������� ����� ��� �� �� ��� �����;-)',true,$id);
   if ($GLOBALS['LF']) WRL('[SERVER] ������������ ['.$N.'] ����� ������� ������������ ['.$U.'] �� ����...');
  }
 }
 echo '<script>top.R=5</script>';
}

// ���������� ������� ���������� ��� ������������� ����� 

function UsrInf($U)
{$S = '<script>top.R=\'';
 if ($M = GetUser(GetSusr($U))) {
  $S .= '���:~'.$M[0].'~~������� ����������:~'.GetTime(time()-$M[2]);
  if ($_SESSION['prev']) {
   $S .= '~~�����:~'.InfPrv($M[3]);
   if ($_SESSION['prev'] > $M[3]) $S .= '~~IP:~'.$M[1].'~~����:~'.gethostbyaddr($M[1]).'~~�������:~'.$M[4].'~~ID:~'.GetSusr($U);
   if ($I = InfUreg($U)) {
    $S .= ($I[6] ? '~~���:~'.$I[6] : '').($I[7] ? '~~�������:~'.$I[7] : '').'~~���:~'.($I[8] ? '�������' : '�������').'~~���� ��������:~'.$I[9].'~~���� �����������:~'.date("d.m.Y [H:i]",$I[3]).'~~��������� ����:~ '.($I[4] ? date("d.m.Y [H:i]",$I[4]) : '� ������ ���!').'~~�����������������:~ '.($I[11] ? GetTime($I[11]) : '�� ��������...');
    $S .= '~~Email:~'.($I[10] ? $I[10] : '���');
    if ($_SESSION['prev'] > $M[3]) {
   	 $S .= '~~Email ��� ������:~'.$I[2];
    }
    if ($I[15]) $S .= '~~� ����:~'.str_replace("\n","<br>",str_replace("~","&#126;",RepChr($I[15],true)));
    if ($_SESSION['user'] === $U) {
     $S .= '~~<a href="config.php" class="lcl" target="_black_cnfg">'.(($_SESSION['prev'] > 1) ? '�����������������' : '������������� �������').'</a>';
    }
   }
  }
 } else $S .= ' ';
 echo $S.'\'</script>';
}

// ������ �������� ��� ���� �����, ���� �� ���� ������� ������ � ��. 

function CheckName($U,$P,$id)
{
 if (!strlen(Dsp($U))) {
  return '������� ����� � ������, ��� ������ ����� ��� ��������� �����';
 } elseif (!$_REQUEST['j']) {
  return '�������� ������� (JavaScript) � ����� ��������';
 } elseif (!array_key_exists('sesc',$_SESSION)) {
  return '�������� ���� (Cookie) � ����� ��������';
 } elseif (strlen($U) < 3) {
  return '������� �������� �����, ����� ������ ���� �� ����� 3-� ��������';
 } elseif (strlen($U) > 20) {
  return '������� ������� �����, ����� �� ������ ��������� 20 ��������';
 } elseif (ErrChr($U)) {
  return 'C������: '.$GLOBALS['ERC'].' �����������';
 } elseif (strlen(NosmName($U)) < 3) {
  return '����� �� ������������� �������';
 } elseif (CheckWords($U)) {
  return '����� �������� �������� ������������� �������';
 } elseif (!strlen($P)&&!ReadIni(1)) {
  return '�������� ���� ��������';
 } elseif ($T = GetBan($U,$P)) {
  return '�� ������� ����� � ��� ������ ����� '.TmlInf($T);
 } elseif ($Mas = GetAusr()) {
  if (count($Mas) > 111) return '��� ����������, ������� �����';
  foreach ($Mas as $V) {
   $V = GetUser($V); if (CompName($V[0],$U)) return '������������ � ������� ������ ��� ��������� � ����';
  }
 }
 $R = CheckUreg($U,$P);
 switch ($R) {
  case 1 : return '�������� ������';
  case 2 : return '��� ������������ "'.$U.'" ��������� ������';
  case 3 : return '������������ ��� ������ ������� �� ���������������';
  case 4 : return '������������ "'.$U.'" ������������, ���� �� ��������';
  case 5 : return '������������ � �������� ������� ��� ���������������,<br>������� ��������� ����� � ������';
  default : return false;
 }
}

// ������ ������ �������� ������ ��������������� �� �������� �� ������� ��������� 

function GetListUsers()
{if ($M = GetAusr()) {
  $S = '<table border="0" cellspacing="0" cellpadding="5" align="center" class="txt"><tr><td align="center">���/���</td><td align="center">����� �����������</td></tr>';  $C = count($M);
  foreach ($M as &$V) $V = GetUser($V);
  unset($V); sort($M);
  foreach ($M as $V) $S .= '<tr><td align="center"><font class="'.($V[3] ? 'grn' : 'grc').'">'.$V[0].'</font></td><td align="center"><font class="aqc">'.GetTime(time() - $V[2]).'</font></td></tr>';
  return $S.'</table>';
 } else return "";
}

// ������� ������� �������/������������� ����� 

function UserLogn($id,$U,$P)
{UsrChk(); ChkBan(); ChkIni(); ClrTmp(); $ERM = ""; $F = true;
 if (!array_key_exists('user',$_SESSION)) {
  $U = trim(Pms($U)); $P = Dsp($P);
  if (!($ERM = CheckName($U,$P,$id))) { ChkUreg();
   UsrAdd($U,$id); $U = GetName($id); $F = false;
   WRM('~~~S~: ����� ���������� ~U~!',true,$id);
   WRM('U~~~S~: � ��� ����� ������������ ~'.$U.'~ ������ ���!',false,$id);
   if ($GLOBALS['LF']) WRL('> [SERVER] � ��� ����� ������������ ['.$U.'] ������ ���!');
   $_SESSION['mess'] = 0; $_SESSION['cerr'] = 0; $_SESSION['time'] = time(); $_SESSION['lerr'] = time(); $_SESSION['user'] = $U; LoadChat();
  }
 } elseif (GetSess($id)) { $F = false;
   UsrDel($id); WRM('U~~~S~: ������������ ~'.$_SESSION['user'].'~ ����� �� ����...',false); echo '<script>top.location.href="index.php"</script>';
   if ($GLOBALS['LF']) WRL('< [SERVER] ������������ ['.$_SESSION['user'].'] ����� �� ����...'); session_destroy();
 } elseif (array_key_exists('user',$_SESSION)) { $F = false;
   session_destroy(); echo '<script>top.location.href="index.php"</script>';
 }
 if ($F) { $_SESSION['sesc'] = 0;
  echo str_replace('~U~',($U ? htmlspecialchars($U) : ''),str_replace('~EMAIL~',$GLOBALS['EMAIL'],str_replace('~COLUS~',count(GetAusr()),str_replace('~REGUS~',CountUsr(),str_replace('~ERROR~',(strlen($ERM) ? $ERM."!<br><br>" : ""),str_replace('~USERS~',GetListUsers(),file_get_contents('server/login.html')))))));
 }
}

// ��������� ������� ������� 

function LoadChat()
{
 echo str_replace("CHAT","BLACK CHAT :: ".$_SESSION["user"],file_get_contents('server/main.html')); $_SESSION['sesc']++;
}

// �� � ��� ����������, ����� ������� ����, �� �������� ���������� ��� ���� �������������;-) 

session_start(); $I = session_get_cookie_params(); session_set_cookie_params(0,$I['path'],$I['domain'],true); $id = session_id(); $LF = ReadIni(3);

if (!array_key_exists('user',$_SESSION)) {

  UserLogn($id,@$_REQUEST['l'],@$_REQUEST['p']);

} elseif (GetSess($id)) {
  if (array_key_exists('c',$_REQUEST)) {
   if (array_key_exists('m',$_REQUEST)) $_REQUEST['m'] = str_replace("~","&#126;",$_REQUEST['m']);
   switch ($_REQUEST['c']) {
    case 0 : UserLogn($id,"",""); break;
    case 1 : MesGet($id); break;
    case 2 : MesPut($id,$_REQUEST['m'],$_REQUEST['f'],$_REQUEST['p']); break;
    case 3 : LdrUsr(); break;
    case 4 : UsrInf($_REQUEST['u']); break;
   default : if ($_SESSION['prev'] > 1) {
    switch ($_REQUEST['c']) {
     case 5 : AdmBan($id,$_REQUEST['m'],$_REQUEST['f'],$_REQUEST['p']); break;
    }
   }
  }
 } elseif (ReadIni(2)||($_SESSION['sesc'] < 3)) LoadChat(); else UserLogn($id,"","");
  GetArrest($id);
} else {
 UserLogn($id,"","");
}

?>