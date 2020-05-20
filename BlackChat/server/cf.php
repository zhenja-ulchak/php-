<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<html><head><link href="config.css" rel="stylesheet" type="text/css"></head><body>
<table border="0" cellspacing="0" cellpadding="0" align="center" class="txt" width="100%"><form action="cf.php" method="post" target="CU"><tr valign="top"><td align="center">
<?

include("general.php"); chdir("../");

// Отображает основную форму 

function ShowInfo($U)
{global $Month;
 if ($U = InfUreg($U)) { $D = explode(".",$U[9]); $D[0] = (integer) $D[0]; $D[1] = $Month[$D[1]-1]; $A = CheckAusr($U[0]);
  $S = '<table border="0" cellspacing="0" cellpadding="3" align="center" class="txt"><tr><td width="140">Ник:</td><td width="200"><font class="yel">'.htmlspecialchars($U[0]).'</font></td><td></td></tr>
  <tr><td>Права:</td><td><font class="grn">'.InfPrv($U[5]).'</font></td><td></td></tr>
  <tr><td>Дата регистрации:</td><td><font class="grc">'.date("d.m.Y [H:i]",$U[3]).'</font></td><td></td></tr>
  <tr><td>Последний вход:</td><td><font class="grc">'.($U[4] ? date("d.m.Y [H:i]",$U[4]) : ($A ? 'В первый раз!' : 'Ещё не заходил...')).'</font></td><td></td></tr>
  <tr><td>Продолжительность:</td><td><font class="grc">'.($U[11] ? GetTime($U[11]) : 'Не известно...').'</font></td><td></td></tr>
  <tr><td>Текущая активность:</td><td>'.($A ? '<font class="aqc">'.GetTime(time()-$A[2]).'</font>' : '<font class="grc">Нет</font>').'</td><td></td></tr>
  <tr><td>Имя:</td><td><input type="text" name="name" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[6]).'"></td><td></td></tr>
  <tr><td>Фамилия:</td><td><input type="text" name="surn" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[7]).'"></td><td></td></tr>
  <tr><td>Дата рождения:</td><td><select name="dadt" class="frm"><option>Число</option>'.DaList($D[0]).'</select>&nbsp;&nbsp;&nbsp;<select name="mndt" class="frm"><option>Месяц</option>'.MnList($D[1]).'</select>&nbsp;&nbsp;&nbsp;<select name="yrdt" class="frm"><option>Год</option>'.YrList($D[2]).'</select></td><td><font class="grn">*</font></td></tr>
  <tr><td>Пол:</td><td>М&nbsp;<input type="radio" name="usex" value="0" class="chk"'.(!$U[8] ? ' checked' : '').'>&nbsp;&nbsp;&nbsp;Ж&nbsp;<input type="radio" name="usex" value="1" class="chk"'.($U[8] ? ' checked' : '').'></td><td></td></tr>
  <tr><td>Общий E-mail:</td><td><input type="text" name="gmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($U[10]).'"></td><td></td></tr>
  <tr><td>E-mail для пароля:</td><td><input type="text" name="pmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($U[2]).'"></td><td><font class="grn">*</font></td></tr>
  <tr><td colspan="3"><br></td></tr>
  <tr><td>Пароль:</td><td><input type="text" name="fpas" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[1]).'"></td><td><font class="grn">*</font></td></tr>
  <tr><td>Подтверждение:</td><td><input type="password" name="lpas" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($U[1]).'"></td><td><font class="grn">*</font></td></tr>';
  if (($U[0] !== $_SESSION['user'])&&PrevUser()) {
   $S .= '<tr><td colspan="3"><br></td></tr><tr><td>Блокировка:</td><td><input type="checkbox" name="busr" class="chk"'.($U[12] ? ' checked' : '').'></td><td></td></tr>';
   if ($_SESSION['prev'] == 3) $S .= '<tr><td>Администратор:</td><td><input type="checkbox" name="prev" class="chk"'.(($U[5] > 1) ? ' checked' : '').'></td><td></td></tr>';
  }
  $S .= '<tr><td colspan="3"><br></td></tr><tr><td colspan="2">Дополнительная информация:<br><br><textarea style="width: 100%" rows="6" name="info" class="frm">'.htmlspecialchars($U[15]).'</textarea></td><td></td></tr>
  <tr><td colspan="3"><br></td></tr><tr><td><script>function Del(F) {if (confirm("Точно?")) { F.c.value="deluser"; F.submit(); } }</script><input type="button" class="but" onclick="Del(this.form)" value="Удалить профиль"></td><td align="right"><input type="submit" class="but" value="Сохранить"></td><td></td></tr><input type="hidden" name="user" value="'.$U[0].'"><input type="hidden" name="c" value="upduser"></table>';
  echo $S;
 }
}

// Сравнивает привелегии 

function PrevUser()
{
 if ($U = InfUreg($_REQUEST['user'])) {
  if ($_SESSION['prev'] > $U[5]) return true; else return false;
 } else return false;
}

// Удаляет определённого юзера из бан листа 

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

// Обновляет профиль юзера 

function UpdUser()
{$user = $_REQUEST['user']; $name = $_REQUEST['name']; $surn = $_REQUEST['surn']; $gmal = $_REQUEST['gmal']; $pmal = $_REQUEST['pmal']; $fpas = $_REQUEST['fpas']; $lpas = $_REQUEST['lpas']; $info = $_REQUEST['info']; $dadt = $_REQUEST['dadt']; $mndt = $_REQUEST['mndt']; $yrdt = $_REQUEST['yrdt'];
 $user = Pms($user); $name = Pms($name); $surn = Pms($surn); $fpas = Dsp($fpas); $lpas = Dsp($lpas); $info = Pms($info,false); $gmal = Dsp(strtolower($gmal)); $pmal = Dsp(strtolower($pmal));
 if (!isset($_REQUEST['usex'])||!$pmal||!$fpas||!$lpas||!$dadt||!$mndt||!$yrdt||($dadt === 'Число')||($mndt === 'Месяц')||($yrdt === 'Год')) {
  return 'red">Ошибка: заполнены не все обязательные поля!';
 }
 elseif (strlen($name) > 20) {
  return 'red">Ошибка: имя имеет недопустимую длину!';
 }
 elseif (CheckWords($name)) {
  return 'red">Ошибка: имя содержит элементы ненормативной лексики!';
 }
 elseif (ErrChr($name)) {
  return 'red">Ошибка: имя содержит недопустимые символы!';
 }
 elseif (strlen($surn) > 20) {
  return 'red">Ошибка: фамилия имеет недопустимую длину!';
 }
 elseif (CheckWords($surn)) {
  return 'red">Ошибка: фамилия содержит элементы ненормативной лексики!';
 }
 elseif (ErrChr($surn)) {
  return 'red">Ошибка: фамилия содержит недопустимые символы!';
 }
 elseif (strlen($gmal)&&(!strchr($gmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($gmal) < 7)||CheckMail($gmal)||(strlen($pmal) > 25))) {
  return 'red">Ошибка: общий email адрес введен неверно!';
 }
 elseif (!strchr($pmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($pmal) < 7)||CheckMail($pmal)||(strlen($pmal) > 25)) {
  return 'red">Ошибка: email адрес для пароля введен неверно!';
 }
 elseif ($fpas !== $lpas) {
  return 'red">Ошибка: пароли не совпадают!';
 }
 elseif (strlen($fpas) < 8) {
  return 'red">Ошибка: неверная длина пароля, пароль должен быть не менее 8 символов!';
 }
 elseif (strlen($info) > 1000) {
  return 'red">Ошибка: текст дополнительной информации слишком большой!';
 }
 elseif (CheckSpace($info)) {
  return 'red">Ошибка: текст дополнительной информации содержит слишком длинные слова!';
 }
 elseif (CheckWords($info)) {
  return 'red">Ошибка: текст дополнительной информации содержит ненормативную лексику!';
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
   UpdUreg($U); return 'grn">Данные сохранены!';
  } else return 'red">Пользователь "'.$_REQUEST['user'].'" в базе не обнаружен!';
 }
}

// Выводит список забаненных юзеров если они есть... 

function GetBanList()
{global $RSDR,$BNLF; ChkBan(); clearstatcache(); $S = "";
 if (file_exists($RSDR.$BNLF)&&filesize($RSDR.$BNLF)) {
  $Mas = explode("\n",trim(file_get_contents($RSDR.$BNLF)));
  $S .= '<table border="0" cellspacing="0" cellpadding="3" align="center" class="txt" width="500"><tr align="center"><td colspan="3">';
  $S .= 'Всего забанненых: <font class="aqc">'.count($Mas).'</font> &nbsp; Текущая дата: <font class="grn">'.date("Y.m.d [H:i]").'</font><br><br></td></tr>';
  $S .= '<tr><td colspan="3" align="center"><a href="cf.php?c=clearban" class="grc" target="CU" onclick="return Dbn()">Очистить весь бан-лист?</a><br><br><script>function Dbn() { if (confirm("Удалить всех забанненых?")) return true; else return false; }</script></td></tr>';
  foreach ($Mas as $V) { $S .= '<tr align="center">';
   $I = explode("\t",$V); if ($I[1] === "0.0.0.0") {
    $S .= '<td align="right" width="230"><a href="cf.php?delban='.rawurlencode($I[0]).'" class="txt" target="CU">'.$I[0].'</a></td><td width="150"><font class="red" title="Осталось: '.TmlInf($I[2]).'.">'.date("Y.m.d [H:i]",$I[2]).'</td><td width="120" align="left"></td></font>';
   } else {
    $S .= '<td align="right" width="230"><a href="cf.php?delban='.rawurlencode($I[0]).'" class="aqc" target="CU">'.$I[0].'</a></td><td width="150"><font class="red" title="Осталось: '.TmlInf($I[2]).'.">'.date("Y.m.d [H:i]",$I[2]).'</td><td width="120" align="left">'.$I[1].'</td></font>';
   }
   $S .= '</tr>';
  }
  $S .= '</table>';
 }
 return $S;
}

// При удалении пользователя из базы удаляет его активный профиль 

function UsrActDel()
{if ($U = GetSusr($_REQUEST['user'])) { $N = GetName($U); UsrDel($U);
  WRM('U~~~S~: Регистрация пользователя ~'.$N.'~ была удалёна из базы и он покидает чат...',false);
  if (ReadIni(3)) WRL('- [SERVER] регистрация пользователя ['.$N.'] была удалёна из базы и он покидает чат...');
 }
}

// Выводит данные о истории сообщений, если она есть... 

function GetLogFile()
{global $USDR,$LOGF;
 if (file_exists($USDR.$LOGF)&&filesize($USDR.$LOGF)) {
  return 'Размер лога в байтах: <font class="grn">'.filesize($USDR.$LOGF).'</font> &nbsp;&nbsp;&nbsp; <a href="cf.php?c=viewlog" class="txt" target="_blank">Просмотр</a> &nbsp;&nbsp;&nbsp; <a href="cf.php?c=clearlog" class="grc" target="CU" onclick="return confirm(\'В натуре?\')">Очистить</a>';
 }
}

session_start(); $I = session_get_cookie_params(); session_set_cookie_params(0,$I['path'],$I['domain'],true); $U = false;

if (array_key_exists('prev',$_SESSION)&&$_SESSION['prev']) {

  if (array_key_exists('user',$_REQUEST)&&array_key_exists('c',$_REQUEST)) {
   if (($_REQUEST['c'] === 'deluser')&&PrevUser()) {
    UsrActDel(); if (DelUreg($_REQUEST['user'])) echo '<font class="grn">Пользователь "'.$_REQUEST['user'].'" был удалён из базы!</font><br><br>'; else '<font class="red">Пользователь "'.$_REQUEST['user'].'" в базе не найден!</font><br><br>'; if ($_SESSION['prev'] > 1) $_REQUEST['user'] = ""; else $_REQUEST['user'] = $_SESSION['user'];
   } elseif (($_REQUEST['c'] === 'deluser')&&($_REQUEST['user'] === $_SESSION['user'])&&($_SESSION['prev'] < 3)) {
    UsrActDel(); DelUreg($_REQUEST['user']); echo '<script>alert("Ваши данные были полностью удалены!")</script>';
   } elseif ((PrevUser()||($_REQUEST['user'] === $_SESSION['user']))&&($_REQUEST['c'] === 'upduser')) echo '<font class="'.UpdUser().'</font><br><br>';
   ChkUreg();
  }

  if ($_SESSION['prev'] > 1) {
   if (array_key_exists('config',$_REQUEST)) {
    if (UpdateIni(array((array_key_exists('chatg',$_REQUEST) ? 1 : 0),(array_key_exists('chatc',$_REQUEST) ? 1 : 0),(array_key_exists('chatl',$_REQUEST) ? 1 : 0),(array_key_exists('chatr',$_REQUEST) ? 1 : 0),(array_key_exists('chatn',$_REQUEST) ? 1 : 0),(array_key_exists('chatf',$_REQUEST) ? 1 : 0),(array_key_exists('chatd',$_REQUEST) ? 1 : 0)))) echo '<font class="grn">Настройки сохранены!</font><br><br>'; else echo '<font class="red">Не удалось сохранить настройки!</font><br><br>';
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
    $_SESSION['cuser'] = ""; ChkIni(); $C = ReadIni(); echo '- <font class="yel">'.$_SESSION['users'].'</font> -<br><table border="0" cellspacing="0" cellpadding="3" align="center" class="txt"><tr><td width="280">Гостевой вход:</td><td><input type="checkbox" class="chk" name="chatg"'.($C[0] ? ' checked' : '').'></td></tr><tr><td>Несколько клиентов для одной сессии:</td><td><input type="checkbox" class="chk" name="chatc"'.($C[1] ? ' checked' : '').'></td></tr><tr><td>Записывать все сообщения в лог:</td><td><input type="checkbox" class="chk" name="chatl"'.($C[2] ? ' checked' : '').'></td></tr><tr><td>Регистрация новых пользователей:</td><td><input type="checkbox" class="chk" name="chatr"'.($C[3] ? ' checked' : '').'></td></tr><tr><td>Автоудаление старых учётных записей:</td><td><input type="checkbox" class="chk" name="chatd"'.($C[6] ? ' checked' : '').'></td></tr><tr><td>Блокировка ненормативной лексики:</td><td><input type="checkbox" class="chk" name="chatn"'.($C[4] ? ' checked' : '').'></td></tr><tr><td>Блокировка флуда:</td><td><input type="checkbox" class="chk" name="chatf"'.($C[5] ? ' checked' : '').'></td></tr><input type="hidden" name="config" value="1"></table><br><br><input type="submit" class="but" value="Сохранить"><script>setTimeout(\'top.CU.location.href="cf.php"\',300000)</script><br><br><br>'.GetLogFile().'<br><br><br>'.GetBanList();
   } else ShowInfo($_SESSION['user']);
  } else {
   if ($_SESSION['prev'] > 1) $_SESSION['cuser'] = $_REQUEST['user'];
   if (PrevUser()||($_REQUEST['user'] === $_SESSION['user'])) ShowInfo($_REQUEST['user']); else ShowInfo($_SESSION['user']);
  }

if ($_SESSION['prev'] > 1) echo '<script>top.UL.location.href="ul.php"</script>';

}

?>
</td></tr></form></table></body></html>