<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<html><head><link href="config.css" rel="stylesheet" type="text/css"></head><body onload="top.UL.location.href='#current'">
<?

include("general.php"); chdir("../");

session_start(); $I = session_get_cookie_params(); session_set_cookie_params(0,$I['path'],$I['domain'],true);

if (array_key_exists('prev',$_SESSION)&&array_key_exists('cuser',$_SESSION)&&($_SESSION['prev'] > 1)) {

$M = GetAusr(); $R = 0; $G = 0;
foreach ($M as $V) {
 if (GetPrev($V)) $R++; else $G++;
}

echo '<table border="0" cellspacing="1" cellpadding="3" align="center" class="txt" width="100%" bgcolor="#C1C1C1">';
echo '<tr bgcolor="#000000"><td colspan="3" align="center"><font class="grn">'.$R.'</font> + <font class="aqc">'.$G.'</font></td><td align="center">'; if ($_SESSION['cuser']) echo '<a href="cf.php" class="txt" target="CU">Конфигурация чата</a>'; else echo '<font class="red">Конфигурация чата</font>'; echo '</td></tr>';

$M = GetUreg(); sort($M);
foreach ($M as $V) { $I = InfUreg($V);
 echo '<tr bgcolor="#000000"><td width="22" align="center">'; if ($I[12]) echo '<font class="grc">B</font>';
 echo '</td><td width="22" align="center">'; if ($I[5] > 1) echo '<font class="red">A</font>';
 echo '</td><td width="22" align="center">'; if (GetSusr($I[0])) echo '<font class="grn">C</font>';
 echo '</td><td width="269" align="center">'; if ($I[0] === $_SESSION['cuser']) echo '<font id="current" class="red">'.$I[0].'</font>'; else echo '<a href="cf.php?user='.rawurlencode($I[0]).'" class="'.(($I[0] === $_SESSION['user']) ? 'aqc' : ((intval((time()-$I[3])/60/60/24) < 3) ? 'grn' : 'txt' )).'" target="CU" title="Последний вход: '.($I[4] ? date("d.m.Y [H:i]",$I[4]) : 'Ещё не заходил...').'">'.$I[0].'</a>';
 echo '</td></tr>';
}

$_SESSION['users'] = count($M);

echo '</table><script>setTimeout(\'top.UL.location.href="ul.php"\',300000)</script>';

}

?>
</body></html>