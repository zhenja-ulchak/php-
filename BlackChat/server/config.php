<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><meta http-equiv="content-type" content="text/html; charset=windows-1251"><link href="config.css" rel="stylesheet" type="text/css">
<?

session_start(); $I = session_get_cookie_params(); session_set_cookie_params(0,$I['path'],$I['domain'],true);

if (array_key_exists('prev',$_SESSION)&&$_SESSION['prev']) {
  echo '<title>BLACK CHAT :: '.(($_SESSION['prev'] > 1) ? 'ADMC' : 'EDIT').' :: '.$_SESSION['user'].'</title>';
  if ($_SESSION['prev'] > 1) $_SESSION['cuser'] = $_SESSION['user'];
 } else echo '<script>this.close()</script>';

?></head><frameset cols="355,*" framespacing="0" frameborder="0">
<frame src="ul.php" name="UL" scrolling="Auto" marginwidth="0" marginheight="0">
<frame src="cf.php" name="CU" scrolling="Auto" marginwidth="0" marginheight="0">
</frameset></html>