<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="content-type" content="text/html; charset=windows-1251"><link href="register.css" rel="stylesheet" type="text/css"><title>Регистрация нового пользователя</title></head><body onload="regf.user.focus()">
<table border="0" cellspacing="0" cellpadding="5" align="center" class="txt">
<?

include("general.php"); chdir("../");

$ERM = ""; $RFR = true;

if (!ReadIni(4)) {
 echo '<tr><td><h2 align="center">Регистрация новых пользователей в данный момент не возможна!</h1></td></tr>'; $RFR = false;
}

if (isset($_REQUEST['user'])&&ReadIni(4)) {
 $user = $_REQUEST['user']; $name = $_REQUEST['name']; $surn = $_REQUEST['surn']; $gmal = $_REQUEST['gmal']; $pmal = $_REQUEST['pmal']; $fpas = $_REQUEST['fpas']; $lpas = $_REQUEST['lpas']; $info = $_REQUEST['info']; $dadt = $_REQUEST['dadt']; $mndt = $_REQUEST['mndt']; $yrdt = $_REQUEST['yrdt'];
 $user = Pms($user); $name = Pms($name); $surn = Pms($surn); $fpas = Dsp($fpas); $lpas = Dsp($lpas); $info = Pms($info,false); $gmal = Dsp(strtolower($gmal)); $pmal = Dsp(strtolower($pmal));
 if (!$user||!isset($_REQUEST['usex'])||!$pmal||!$fpas||!$lpas||!$dadt||!$mndt||!$yrdt||($dadt === 'Число')||($mndt === 'Месяц')||($yrdt === 'Год')) {
  $ERM = 'заполнены не все обязательные поля';
 }
 elseif ((strlen($user) > 20)||(strlen($user) < 3)) {
  $ERM = 'ник имеет недопустимую длину';
 }
 elseif (ErrChr($user)) {
  $ERM = 'символы '.$GLOBALS['ERC'].' не допустимы в нике';
 }
 elseif (strlen(NosmName($user)) < 3) {
  $ERM = 'ник не соответствует формату';
 }
 elseif (CheckWords($user)) {
  $ERM = 'ник содержит элементы ненормативной лексики';
 }
 elseif (InfUreg($user)) {
  $ERM = 'пользователь с похожим ником уже зарегистрирован в чате';
 }
 elseif (strlen($name) > 20) {
  $ERM = 'имя имеет недопустимую длину';
 } 
 elseif (CheckWords($name)) {
  $ERM = 'имя содержит элементы ненормативной лексики';
 }
 elseif (ErrChr($name)) {
  $ERM = 'имя содержит недопустимые символы';
 }
 elseif (strlen($surn) > 20) {
  $ERM = 'фамилия имеет недопустимую длину';
 }
 elseif (CheckWords($surn)) {
  $ERM = 'фамилия содержит элементы ненормативной лексики';
 }
 elseif (ErrChr($surn)) {
  $ERM = 'фамилия содержит недопустимые символы';
 }
 elseif (strlen($gmal)&&(!strchr($gmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($gmal) < 7)||CheckMail($gmal)||(strlen($pmal) > 25))) {
  $ERM = 'общий email адрес введен неверно';
 }
 elseif (!strchr($pmal,'@')||!(strrpos($pmal,'.')&&(strrpos($pmal,'.') < (strlen($pmal)-2)))||(strlen($pmal) < 7)||CheckMail($pmal)||(strlen($pmal) > 25)) {
  $ERM = 'email адрес для восстановления пароля введен неверно';
 }
 elseif ($fpas !== $lpas) {
  $ERM = 'пароли не совпадают'; 
 }
 elseif (strlen($fpas) < 8) {
  $ERM = 'неверная длина пароля, пароль должен быть не менее 8 символов';
 }
 elseif (strlen($info) > 1000) {
  $ERM = 'текст дополнительной информации слишком большой';
 }
 elseif (CheckSpace($info)) {
  $ERM = 'текст дополнительной информации содержит слишком длинные слова';
 }
 elseif (CheckWords($info)) {
  $ERM = 'текст дополнительной информации содержит ненормативную лексику';
 }
 elseif ($Mas = GetAusr()) {
  foreach ($Mas as $V) {
   $V = GetUser($V); if (CompName($V[0],$user)) $ERM = 'пользователь с похожим ником уже находится в чате';
  }
 }
 if (!$ERM) {
  $P = 1; if (!file_exists($RSDR.$REGF)) $P = 3; $RFR = false;
  if ($F = fopen($RSDR.$REGF,'ab')) {
   $T = array_reverse(explode(" ",microtime())); $T[1] = substr($T[1],2); $T[2] = implode("",$T).mt_rand(111,999); fwrite($F,$user."\t".$T[2]."\n"); fclose($F);
   $F = fopen($RSDR.$PRUS.$T[2],'wb'); fwrite($F,$fpas."\t".$pmal."\t".$T[0]."\t0\t".$P."\t".$name."\t".$surn."\t".$_REQUEST['usex']."\t".GetDfn($dadt,$mndt,$yrdt)."\t".$gmal."\t0\t0\t0\t0\t".Ddn($info)); fclose($F);
   echo '<tr><td colspan="2" width="100%" height="100%" align="center" valign="middle"><font class="grn">Регистрация прошла успешно!</font><br><br><a href="../index.php" class="txt">вернутся на главную</a><br><br><a href="javascript:logf.submit()" class="txt">войти в чат</a></td></tr>
   <form action="../index.php" method="post" name="logf"><input type="hidden" name="l" value="'.$user.'"><input type="hidden" name="p" value="'.$fpas.'"><input type="hidden" name="j" value="1"></form>';
   if (ReadIni(3)) WRL('+ [SERVER] регистрация нового пользователя ['.$user.'] прошла успешно!');
  } else $ERM = 'регистрация закончилась неудачей, попробуйте позже';
 }
}

// Формат полей: 1 - Пароль, 2 - Емаил для пароля, 3 - Дата регистрации, 4 - Дата последнего входа, 5 - Привелегии, 6 - Имя, 7 - Фамилия, 8 - Пол, 9 - Дата рождения, 10 - Емаил общий, 11 - Продолжительность последнего сеанса, 12 - Используется для блокировки пользователя, 13, 14 - Зарезервированные поля, 15 - Информация о пользователе.

if ($ERM) echo '<tr><td colspan="5"><font class="erc">Ошибка: '.$ERM.'!</font><br><br></td></tr>';

if ($RFR) {

echo '<form action="register.php" method="post" name="regf"><tr><td width="140">Ник:</td><td width="200"><input type="text" name="user" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($user).'"></td><td><font class="grn">*</font></td><td width="20" rowspan="14"></td><td rowspan="14" width="300" valign="top">Поля помеченные символом <font class="grn">*</font> являются обязательными.<br><br>Дополнительная информация о Вас не должна превышать 1000 символов.<br><br>E-Mail адрес в поле "Общий E-mail" будет доступен всем зарегистрированным в чате пользователям.<br><br>В поле "E-mail для пароля" необходимо ввести E-mail адрес на который будет отправлен Ваш пароль, если Вы вдруг его забудете.<br><br>Длина пароля должна быть не менее 8 символов.<br><br>Вся Ваша информация будет доступна только зарегистрированным пользователям.</td></tr>
<tr><td>Имя:</td><td><input type="text" name="name" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($name).'"></td><td></td></tr>
<tr><td>Фамилия:</td><td><input type="text" name="surn" size="33" maxlength="20" class="frm" value="'.htmlspecialchars($surn).'"></td><td></td></tr>
<tr><td>Дата рождения:</td><td><select name="dadt" class="frm"><option>Число</option>'.DaList($_REQUEST['dadt']).'</select>&nbsp;&nbsp;&nbsp;<select name="mndt" class="frm"><option>Месяц</option>'.MnList($_REQUEST['mndt']).'</select>&nbsp;&nbsp;&nbsp;<select name="yrdt" class="frm"><option>Год</option>'.YrList($_REQUEST['yrdt']).'</select></td><td><font class="grn">*</font></td></tr>
<tr><td>Пол:</td><td>М&nbsp;<input type="radio" name="usex" value="0" class="chk"'.(!$_REQUEST['usex'] ? ' checked' : '').'>&nbsp;&nbsp;&nbsp;Ж&nbsp;<input type="radio" name="usex" value="1" class="chk"'.($_REQUEST['usex'] ? ' checked' : '').'></td><td></td></tr>
<tr><td>Общий E-mail:</td><td><input type="text" name="gmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($gmal).'"></td><td></td></tr>
<tr><td>E-mail для пароля:</td><td><input type="text" name="pmal" size="33" maxlength="25" class="frm" value="'.htmlspecialchars($pmal).'"></td><td><font class="grn">*</font></td></tr>
<tr><td colspan="3"><br></td></tr>
<tr><td>Пароль:</td><td><input type="password" name="fpas" size="33" maxlength="20" class="frm"></td><td><font class="grn">*</font></td></tr>
<tr><td>Подтверждение:</td><td><input type="password" name="lpas" size="33" maxlength="20" class="frm"></td><td><font class="grn">*</font></td></tr>
<tr><td colspan="3"><br></td></tr>
<tr><td colspan="2">Дополнительная информация о Вас:<br><br><textarea style="width: 100%" rows="6" name="info" class="frm">'.htmlspecialchars($info).'</textarea></td><td></td></tr>
<tr><td colspan="3"><br></td></tr>
<tr><td><input type="button" value="НА ГЛАВНУЮ" class="but" onclick="top.location.href = \'../index.php\'"></td><td align="right"><input type="submit" value="ЗАРЕГИСТРИРОВАТЬСЯ!" class="but"></td><td></td></tr>
</form>';

}

?>
</table></body></html>