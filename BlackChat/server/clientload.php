<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

session_start(); $I = session_get_cookie_params(); session_set_cookie_params(0,$I['path'],$I['domain'],true);

if ($_SESSION['prev'] > 1) $b = 'a'; else $b = 'u';

switch ($_REQUEST['c']) {
  case 1 : $S = file_get_contents('../client/'.$b.'top'); break;
  case 2 : $S = file_get_contents('../client/'.$b.'script'); break;
  case 3 : $S = file_get_contents('../client/'.$b.'low'); break;
}

echo str_replace('~U~',$_SESSION['user'],$S);

?>