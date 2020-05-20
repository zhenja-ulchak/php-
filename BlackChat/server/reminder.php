<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="content-type" content="text/html; charset=windows-1251"><title>Восстановление пароля</title><link href="reminder.css" rel="stylesheet" type="text/css"></head><body onload="regf.rlog.focus()">
<table border="0" align="center" height="100%"><tr><td align="center" valign="middle"><table border="0" cellspacing="0" cellpadding="5" align="center" class="txt">
<?

include('general.php'); chdir("../");

$SRF = false; $ERM = "";

if (strlen($_REQUEST['rlog'])&&strlen($_REQUEST['reml'])) {
 if (($Mas = InfUreg(Pms($_REQUEST['rlog'])))&&(strlen($Mas[0]) == strlen(Pms($_REQUEST['rlog'])))) {
  if (strtolower(Dsp($_REQUEST['reml'])) === $Mas[2]) $SRF = $Mas; else $ERM = 'Неверный Email адрес';
 } else $ERM = 'Введите правильно Ваш логин и Email адрес, после чего повторите попытку';
}

if ($SRF) {
$Headr = "MIME-Version: 1.0\r\nContent-Type: text/plain; charset=Windows-1251\r\nContent-Transfer-Encoding: base64\r\nFrom: BLACK CHAT <".$EMAIL.">\r\n";
if (@mail($SRF[2],"Восстановление пароля",base64_encode("Здравствуйте ".($SRF[6] ? $SRF[6]." ".$SRF[7] : $SRF[0])."!\r\n\r\nБлагодарим Вас за использование службы восстановления пароля.\r\n\r\nДля входа в чат под логином \"".$SRF[0]."\" используйте следующий пароль: ".$SRF[1]."\r\n\r\nПо всем вопросам пишите на этот адрес: ".$EMAIL.".\r\n\r\nhttp://".$_SERVER['SERVER_NAME']." - чат созданный для простого общения;-)"),$Headr))
 echo '<tr><td align="center">Уважаем'.($SRF[8] ? "ая" : "ый").' <font class="grn">'.$SRF[0].'</font><br><br>Пароль для входя в чат был отправлен Вам на адрес: <font class="grn">'.$SRF[2].'</font>.<br><br><a href="../index.php" class="txt">Вернутся на главную</a></td></tr>';
else
 echo '<tr><td align="center">Уважаем'.($SRF[8] ? "ая" : "ый").' <font class="grn">'.$SRF[0].'</font><br><br><font class="erc">Пароль для входа в чат не был отправлен Вам из-за сбоя на сервере, попробуйте позже воспользоваться данной службой.</font><br><br>или пишите на этот адрес: <a href="mailto:'.$EMAIL.'" class="txt">'.$EMAIL.'</a><br><br><a href="../index.php" class="txt">Вернутся на главную</a></td></tr>';
} else {
 echo '<form action="reminder.php" method="post" name="regf"><tr><td colspan="2" align="center">'.($ERM ? '<font class="erc">'.$ERM.'!</font>' : 'Введите Ваш логин и Еmail адрес<br>который Вы указали при регистрации в чате.').'<br><br></td></tr><tr><td><table border="0" cellspacing="0" cellpadding="5" align="center" class="txt" width="300"><tr><td width="50">Логин:</td><td><input type="text" name="rlog" size="33" maxlength="20" class="frm" value="'.$_REQUEST['rlog'].'"></td></tr><tr><td>Email:</td><td><input type="text" name="reml" size="33" maxlength="25" class="frm" value="'.$_REQUEST['reml'].'"></td></tr><tr><td colspan="2" align="center"><br><br><input type="submit" value="Напомнить!" class="but"></td></tr><tr><td colspan="2" align="center"><br><br><a href="../index.php" class="txt">Вернутся на главную</a></td></tr></table></td></tr></form>';
}

?>
</table></td></tr></table></body></html>