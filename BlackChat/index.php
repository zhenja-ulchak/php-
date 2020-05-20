<?

header("Cache-Control: no-cache, must-revalidate");
header("Expires: ".date("r"));

include("server/general.php");

// Проверяет зарегистрирован-ли пользователь, если да проверяем пароль... 

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

// Функции для удаления старых файлов, чтоб не засорять директории... 

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

// Создаёт активный профиль для нового пользователя 

function UsrAdd($U,$id)
{global $USDR,$ULDR; $P = 0;
 if ($R = InfUreg($U)) {
  $P = $R[5]; $U = $R[0];
 }
 $F = fopen($USDR.$ULDR.$id,'wb'); fwrite($F,$U."\t".$_SERVER['REMOTE_ADDR']."\t".time()."\t".$P."\t".$_SERVER['HTTP_USER_AGENT']); fclose($F);
 $_SESSION['prev'] = $P;
}

// Обновляет время активного профиля 

function UsrUpd($id)
{global $USDR,$ULDR;
 if (file_exists($USDR.$ULDR.$id)) touch($USDR.$ULDR.$id);
}

// Удаляет активный профиль в случае если запись устарела (разрыв связи) 

function UsrChk()
{global $USDR,$ULDR,$LTF; $M = GetAusr();
 foreach ($M as $V) {
  if ((time()-filemtime($USDR.$ULDR.$V)) > $LTF) {
   $U = GetName($V); UsrDel($V); WRM('U~~~S~: Нас покинул ~'.$U.'~ по причине потери связи...',false);
   if ($GLOBALS['LF']) WRL('? [SERVER] нас покинул ['.$U.'] по причине потери связи...');
  }
 }
}

// Добавляет в бан лист юзера 

function AddBan($id,$T)
{global $RSDR,$BNLF;
 if ($Mas = GetUser($id)) {
  $F = fopen($RSDR.$BNLF,'ab'); fwrite($F,$Mas[0]."\t".(GetPrev($id) ? '0.0.0.0' : $Mas[1])."\t".(time()+($T*60))."\n"); fclose($F);
 }
}

// Определяет есть ли юзер в бан листе 

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

// Выкидывает пользователя из чата с нужным сообщением 

function SetArrest($id,$U,$M,$T = 60)
{global $USDR,$TSDR; AddBan($id,$T);
 $F = fopen($USDR.$TSDR.$id,'ab'); fwrite($F,'<script>alert("'.$U.': '.addslashes($M).'")</script>'); fclose($F);
}

// Отправляет клиенту скрипт и удаляет его из чата 

function GetArrest($id)
{global $USDR,$TSDR;
 if (file_exists($USDR.$TSDR.$id)&&filesize($USDR.$TSDR.$id)) {
  UsrDel($id); echo file_get_contents($USDR.$TSDR.$id); unlink($USDR.$TSDR.$id); WRM('U',false);
 }
}

// Отправляет клиенту список активных юзеров 

function LdrUsr()
{echo '<script>top.R=';
 $M = GetAusr(); foreach ($M as &$V) $V = GetName($V);
 sort($M); echo '\''.implode("~~",$M).'\'';
 echo '</script>';
}

// Основные функции для отправки сообщений юзерам 

function PutAll($User,$S,$id)
{
 WRM('~~~'.$User.'~: '.$S,false,$id);
 if ($GLOBALS['LF']) WRL('['.$User.'] '.$S);
}

function PutPer($User,$Fyou,$Pers,$S,$id,$Fy)
{if (!$Pers) {
  WRM('~~~'.$User.'~F~U~: '.$S,true,$Fy);
  WRM('~~~'.$User.'~F~'.$Fyou.'~: '.$S,false,$Fy,$id);
  if ($GLOBALS['LF']) WRL('['.$User.'] для ['.$Fyou.'] '.$S);
 } else {
  WRM('~~~'.$User.'~A~U~: '.$S,true,$Fy);
  if ($GLOBALS['LF']) WRL('['.$User.'] лично ['.$Fyou.'] '.$S);
 }
}

function PutMes($S,$Fyou,$Pers,$id)
{if (strlen(Dsp($S))) {
  if ($Fy = GetSusr($Fyou)) PutPer($_SESSION['user'],$Fyou,$Pers,$S,$id,$Fy); else PutAll($_SESSION['user'],$S,$id);
 }
}

// Функция которая принимает сообщения от клиента 
// и проверяет с какой частотой клиент отправляет сообщения на сервак, чтобы определить флуд. 
// Если пользователь отправлял 10 сообщений вподряд с интервалом 3 секунды, то сервер блокирует отправку сообщений данного пользователя 
// на определённый интервал времени в минутах, который будет увеличиватся (колличество повторов * 3) если подобное повторится. 
// Если подобное повторится (3 раза для гостей и 6 раз для зарегиных пользователей) то сервер 
// выкидывает юзера из чата на 1 час. Количество повторов сбрасывается через 1 час, при условии что не было флуда за это время. 
// Также проверяется сообщение на содержание ненормативной лексики, если она есть, то сообщение блокируется 
// Все эти проверки можно выключить в настройках чата. Данные проверки действуют только для пользователей и гостей 

function MesPut($id,$mess,$fyou,$pers)
{
 if (($_SESSION['prev'] < 2)&&ReadIni(5)&&(CheckWords($mess))) {
  $mess = ""; WRM('~~~S~F~U~: Ваше сообщение не было отправленно, так-как содержало ненормативную лексику!',true,$id);
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

// Главная функция для отправки сообщений клиенту 

function GMS($id)
{global $USDR; echo '<script>top.R='; if (file_exists($USDR.$id)) rename($USDR.$id,$USDR.$id.".tmp");
 if (file_exists($USDR.$id.".tmp")&&filesize($USDR.$id.".tmp")) {
  echo '\''.file_get_contents($USDR.$id.".tmp").'\''; unlink($USDR.$id.".tmp");
 } else echo '1'; echo ';top.WF.HMS[0]='.date("G").';top.WF.HMS[1]='.(integer) date("i").';top.WF.HMS[2]='.(integer) date("s").';</script>';
}

// Возвращает клинту сообщения 

function MesGet($id)
{UsrChk(); UsrUpd($id);
 if (($_SESSION['mess'] > 10)&&((time() - $_SESSION['time']) > (($_SESSION['cerr']*3)*60))) {
  WRSD($id); $_SESSION['mess'] = 0;
 }
 if ($_SESSION['cerr'] == (($_SESSION['prev']+1)*3)) BNSE($id);
 GMS($id);
}

// Сервер банит юзеров 

function BNSE($id)
{
 WRM('~~~S~F~U~: За плохое поведение удаляю тебя из чата!',true,$id);
 WRM('~~~S~: пользователь ~'.$_SESSION['user'].'~ удалён из чата на 1 час, по причине плохого поведения...',false,$id);
 if ($GLOBALS['LF']) WRL('^ [SERVER] пользователь ['.$_SESSION['user'].'] удалён из чата на 1 час, по причине плохого поведения...');
 SetArrest($id,'SERVER','плохое поведение!');
}

// Блокируте юзера если он флудит 

function WRSE($id)
{AddBan($id,$_SESSION['cerr']*3);
 WRM('F~~~S~F~U~: Сильно активно себя ведёшь, отдохни '.($_SESSION['cerr']*3).' мин;-)',true,$id);
 WRM('~~~S~: За флуд ~'.$_SESSION['user'].'~ будет молчать '.($_SESSION['cerr']*3).' мин!',false,$id);
 if ($GLOBALS['LF']) WRL('% [SERVER] за флуд ['.$_SESSION['user'].'] будет молчать '.($_SESSION['cerr']*3).' мин!');
}

// Снимает запрет 

function WRSD($id)
{ChkBan();
 WRM('A~~~S~F~U~: Сейчас можешь разговаривать...',true,$id);
 WRM('~~~S~: Сейчас ~'.$_SESSION['user'].'~ может разговаривать, время наказания истекло...',false,$id);
 if ($GLOBALS['LF']) WRL('~ [SERVER] сейчас ['.$_SESSION['user'].'] может разговаривать, время наказния истекло...');
}

// Удаляет пользователя из чата на нужное время 

function AdmBan($id,$U,$M,$T)
{$N = $_SESSION['user'];
 if ($I = GetSusr($U)) {
  if ($_SESSION['prev'] > GetPrev($I)) {
   $T = explode("~",$T); if (strlen(Dsp($M)) < 3) $M = 'не известна...';
   switch ($T[1]) {
    case 1 : $T[2] = $T[0]; $T[1] = 'минут'; break;
    case 2 : $T[2] = $T[0]*60; $T[1] = 'часов'; break;
    case 3 : $T[2] = ($T[0]*60)*24; $T[1] = 'дней'; break;
    } SetArrest($I,$N,$M,$T[2]);
   WRM('~~~S~: ~'.$N.'~ удалил тебя из чата на '.$T[0].' '.$T[1].'! Причина: '.$M,true,$I);
   WRM('~~~S~: ~'.$N.'~ удалил ~'.$U.'~ из чата на '.$T[0].' '.$T[1].'! Причина: '.$M,false,$I,$id);
   WRM('~~~S~: Из чата удалён ~'.$U.'~ на '.$T[0].' '.$T[1].'!',true,$id);
   if ($GLOBALS['LF']) WRL('['.$N.'] удалил ['.$U.'] из чата на '.$T[0].' '.$T[1].'! Причина: '.$M);
  } else {
   WRM('~~~S~: ~'.$N.'~ хотел тебя удалить из чата...',true,$I);
   WRM('~~~S~: Пользователя ~'.$U.'~ невозможно удалить из чата, т.к. у вас одинаковые права или же он Вас круче;-)',true,$id);
   if ($GLOBALS['LF']) WRL('[SERVER] пользователь ['.$N.'] хотел удалить пользователя ['.$U.'] из чата...');
  }
 }
 echo '<script>top.R=5</script>';
}

// Возвращает клиенту информацию для определенного юзера 

function UsrInf($U)
{$S = '<script>top.R=\'';
 if ($M = GetUser(GetSusr($U))) {
  $S .= 'Ник:~'.$M[0].'~~Текущая активность:~'.GetTime(time()-$M[2]);
  if ($_SESSION['prev']) {
   $S .= '~~Права:~'.InfPrv($M[3]);
   if ($_SESSION['prev'] > $M[3]) $S .= '~~IP:~'.$M[1].'~~Хост:~'.gethostbyaddr($M[1]).'~~Браузер:~'.$M[4].'~~ID:~'.GetSusr($U);
   if ($I = InfUreg($U)) {
    $S .= ($I[6] ? '~~Имя:~'.$I[6] : '').($I[7] ? '~~Фамилия:~'.$I[7] : '').'~~Пол:~'.($I[8] ? 'Женский' : 'Мужской').'~~Дата рождения:~'.$I[9].'~~Дата регистрации:~'.date("d.m.Y [H:i]",$I[3]).'~~Последний вход:~ '.($I[4] ? date("d.m.Y [H:i]",$I[4]) : 'В первый раз!').'~~Продолжительность:~ '.($I[11] ? GetTime($I[11]) : 'Не известно...');
    $S .= '~~Email:~'.($I[10] ? $I[10] : 'Нет');
    if ($_SESSION['prev'] > $M[3]) {
   	 $S .= '~~Email для пароля:~'.$I[2];
    }
    if ($I[15]) $S .= '~~О себе:~'.str_replace("\n","<br>",str_replace("~","&#126;",RepChr($I[15],true)));
    if ($_SESSION['user'] === $U) {
     $S .= '~~<a href="config.php" class="lcl" target="_black_cnfg">'.(($_SESSION['prev'] > 1) ? 'Администрирование' : 'Редактировать профиль').'</a>';
    }
   }
  }
 } else $S .= ' ';
 echo $S.'\'</script>';
}

// Всякие проверки для ника юзера, чтоб не было похожих юзеров и пр. 

function CheckName($U,$P,$id)
{
 if (!strlen(Dsp($U))) {
  return 'Введите логин и пароль, или просто логин для гостевого входа';
 } elseif (!$_REQUEST['j']) {
  return 'Включите скрипты (JavaScript) в вашем браузере';
 } elseif (!array_key_exists('sesc',$_SESSION)) {
  return 'Включите куки (Cookie) в вашем браузере';
 } elseif (strlen($U) < 3) {
  return 'Слишком короткий логин, логин должен быть не менее 3-х символов';
 } elseif (strlen($U) > 20) {
  return 'Слишком длинный логин, логин не должен превышать 20 символов';
 } elseif (ErrChr($U)) {
  return 'Cимволы: '.$GLOBALS['ERC'].' недопустимы';
 } elseif (strlen(NosmName($U)) < 3) {
  return 'Логин не соответствует формату';
 } elseif (CheckWords($U)) {
  return 'Логин содержит элементы ненормативной лексики';
 } elseif (!strlen($P)&&!ReadIni(1)) {
  return 'Гостевой вход запрещён';
 } elseif ($T = GetBan($U,$P)) {
  return 'Вы сможете зайти в чат только через '.TmlInf($T);
 } elseif ($Mas = GetAusr()) {
  if (count($Mas) > 111) return 'Чат перегружен, зайдите позже';
  foreach ($Mas as $V) {
   $V = GetUser($V); if (CompName($V[0],$U)) return 'Пользователь с похожим именем уже находится в чате';
  }
 }
 $R = CheckUreg($U,$P);
 switch ($R) {
  case 1 : return 'Неверный пароль';
  case 2 : return 'Для пользователя "'.$U.'" необходим пароль';
  case 3 : return 'Пользователь под данным логином не зарегистрирован';
  case 4 : return 'Пользователь "'.$U.'" заблокирован, вход не возможен';
  case 5 : return 'Пользователь с подобным логином уже зарегистрирован,<br>введите правильно логин и пароль';
  default : return false;
 }
}

// Выдает список активных юзеров атсортированных по алфавиту на вводную страничку 

function GetListUsers()
{if ($M = GetAusr()) {
  $S = '<table border="0" cellspacing="0" cellpadding="5" align="center" class="txt"><tr><td align="center">Имя/Ник</td><td align="center">Время присутствия</td></tr>';  $C = count($M);
  foreach ($M as &$V) $V = GetUser($V);
  unset($V); sort($M);
  foreach ($M as $V) $S .= '<tr><td align="center"><font class="'.($V[3] ? 'grn' : 'grc').'">'.$V[0].'</font></td><td align="center"><font class="aqc">'.GetTime(time() - $V[2]).'</font></td></tr>';
  return $S.'</table>';
 } else return "";
}

// Функция котороя логинит/разлогинивает юзера 

function UserLogn($id,$U,$P)
{UsrChk(); ChkBan(); ChkIni(); ClrTmp(); $ERM = ""; $F = true;
 if (!array_key_exists('user',$_SESSION)) {
  $U = trim(Pms($U)); $P = Dsp($P);
  if (!($ERM = CheckName($U,$P,$id))) { ChkUreg();
   UsrAdd($U,$id); $U = GetName($id); $F = false;
   WRM('~~~S~: Добро пожаловать ~U~!',true,$id);
   WRM('U~~~S~: К нам зашёл пользователь ~'.$U.'~ только что!',false,$id);
   if ($GLOBALS['LF']) WRL('> [SERVER] к нам зашёл пользователь ['.$U.'] только что!');
   $_SESSION['mess'] = 0; $_SESSION['cerr'] = 0; $_SESSION['time'] = time(); $_SESSION['lerr'] = time(); $_SESSION['user'] = $U; LoadChat();
  }
 } elseif (GetSess($id)) { $F = false;
   UsrDel($id); WRM('U~~~S~: Пользователь ~'.$_SESSION['user'].'~ вышел из чата...',false); echo '<script>top.location.href="index.php"</script>';
   if ($GLOBALS['LF']) WRL('< [SERVER] пользователь ['.$_SESSION['user'].'] вышел из чата...'); session_destroy();
 } elseif (array_key_exists('user',$_SESSION)) { $F = false;
   session_destroy(); echo '<script>top.location.href="index.php"</script>';
 }
 if ($F) { $_SESSION['sesc'] = 0;
  echo str_replace('~U~',($U ? htmlspecialchars($U) : ''),str_replace('~EMAIL~',$GLOBALS['EMAIL'],str_replace('~COLUS~',count(GetAusr()),str_replace('~REGUS~',CountUsr(),str_replace('~ERROR~',(strlen($ERM) ? $ERM."!<br><br>" : ""),str_replace('~USERS~',GetListUsers(),file_get_contents('server/login.html')))))));
 }
}

// Загружает нужного клиента 

function LoadChat()
{
 echo str_replace("CHAT","BLACK CHAT :: ".$_SESSION["user"],file_get_contents('server/main.html')); $_SESSION['sesc']++;
}

// Ну и сам обработчик, самый главный блок, из которого вызывается все выше перечисленное;-) 

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