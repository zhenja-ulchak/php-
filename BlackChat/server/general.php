<?

$EMAIL = 'black@black.xx';

$RSDR = 'base/';
$PRUS = 'profiles/';
$USDR = 'session/';
$ULDR = 'users/';
$TSDR = 'prison/';

$BNLF = 'ban';
$REGF = 'users';
$CONF = 'config';
$LOGF = 'history.log';

$OPRF = 365;

$LTF = 250;

// Массивы 

$ERC = '~\'"/\#+-|&%$[](){}^№`.:<>,;=?!_';

$Techr = array('a' => 'а','b' => 'в','h' => 'н','k' => 'к','y' => 'у','c' => 'с','m' => 'м','e' => 'е','o' => 'о','x' => 'х','p' => 'р','t' => 'т');

$Words = array('сука','ёбн','козел','козл','ублюд','чмо','сучк','жоп','говн','козёл','твар','чёрт','шмар','сукка','суки','гнойный',
			   'ванюч','сучий','боёб','боеб','ибал','стрём','дэрм','свин','потрох','уёб','уеб','ибат','бля','казл','монда',
			   'ламер','ламёр','пизд','ганд','хуй','ёбн','шмара','дерм','заеб','заёб','пезд','собачий','стром','отъеб','мондо',
			   'урод','хер','трах','ебат','ебит','страм','падла','гавн','отъеб','хуи','хуе','хуё','отьеб','суки','ебан','стрем',
			   'манда','залуп','ебло','ёбло','ебуч','ебал','ебн','ёбон','еби','пидо','пида','ебну','фуфл','ебан','баеб','баёб',
			   'сучий','засран','ебал','фуфел','хуя','казл','задниц','казёл','ебан','мандо','очко','билять','белять','рыгал');

$Month = array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря');

// Ряд вспомогательных второстепенных функций для работы со строками 

function Rds($S)
{
 while (strpos($S,"  ") !== false) $S = str_replace("  "," ",$S); return trim($S);
}

function Dsp($S)
{
 return str_replace("\t","",str_replace("\r","",str_replace("\n","",str_replace(" ","",$S))));
}

function Pms($S,$F = true)
{
 return Rds(str_replace("\t"," ",str_replace("\r",($F ? " " : ""),($F ? str_replace("\n"," ",$S) : $S))));
}

function Ddn($S)
{
 while (strpos($S,"\n\n\n") !== false) $S = str_replace("\n\n\n","\n\n",$S); return $S;
}

// Преобразует время UNIX в часы, минуты и секунды 

function GetTime($T)
{
 $H = (integer) (($T/60)/60); $M = ($T/60)%60; $S = ($T%60)%60;
 return ($H > 9 ? $H : "0".$H).':'.($M > 9 ? $M : "0".$M).':'.($S > 9 ? $S : "0".$S);
}

// Проверяет строку на наличие ненормативной лексики 

function CheckWords($M)
{global $Words; $M = strtolower($M); $M = Rchr(Dsp($M),true);
 foreach ($Words as $V) if (strpos($M,$V) !== false) return true;
 return false;
}

// Сравнивает два ника, независимо от транслитерации 

function CompName($F,$S)
{$F = strtolower($F); $S = strtolower($S);
 if (Rchr(Rchr(NosmName($F),true),false) === Rchr(Rchr(NosmName($S),true),false)) return true; else return false;
}

// Вспомогательная функция для сравнения ников, которая меняет русские символы на соответствующие латинские и наоборот 

function Rchr($M,$F)
{global $Techr; reset($Techr);
 while (list($K,$V) = each($Techr)) if ($F) $M = str_replace($K,$V,$M); else str_replace($V,$K,$M);
 return $M;
}

// Вспомогательная функция для проверки логина 

function NosmName($U)
{$S = '@1234567890 '; $S = str_split($S);
 foreach ($S as $V) {
  $U = str_replace($V,"",$U);
 }
 return Dsp($U);
}

// Смотрит, если запрещенные символы в имени 

function ErrChr($M)
{global $ERC; $S = str_split($ERC);
 foreach ($S as $V) if (strpos($M,$V) !== false) return true;
 return false;
}

// Создаёт файл конфигурации по умолчанию 
// Первый параметр разрешает или запрещает гостевой вход, 0 - запретить, 1 - разрешить, по умолчанию 1 
// Второй параметр разрешает или запрещает открытие нескольких клиентов для одной сессии, 0 - запретить, 1 - разрешить, по умолчанию 1 
// Третий параметр разрешает или запрещает запись всех сообщений в лог файл, 0 - запретить, 1 - разрешить, по умолчанию 0 
// Четвёртый параметр разрешает или запрещает регистрацию новых пользователей в чате, 0 - запретить, 1 - разрешить, по умолчанию 1 
// Пятый параметр разрешает или нет матерится всем в чате, так только могут админы, 0 - разрешить, 1 - запретить, по умолчанию 1 
// Шестой параметр параметр включает или выключает защиту от флуда, 0 - выключить, 1 - включить, по умолчанию 1 
// Седьмой параметр включает или выключает автоудаление старых учёток из базы, 0 - выключить, 1 - включить, по умолчанию 0 

function CreateIni()
{global $RSDR,$CONF;
 $F = fopen($RSDR.$CONF,'wb'); fwrite($F,'1~1~0~1~1~1~0'); fclose($F);
}

// Читает файл конфигурации, либо весь, либо определённый параметр 

function ReadIni($P = 0)
{global $RSDR,$CONF;
 if (file_exists($RSDR.$CONF)&&filesize($RSDR.$CONF)) $M = explode("~",file_get_contents($RSDR.$CONF)); else return false;
 if ($P) return $M[$P-1]; else return $M;
}

// Обновляет информацию в файле конфигурации 

function UpdateIni($C)
{global $RSDR,$CONF;
 if ($F = fopen($RSDR.$CONF,'wb')) {
  fwrite($F,implode("~",$C)); fclose($F); return true;
 } else return false;
}

// Проверяет файл конфигурации, если не существует - создаёт 

function ChkIni()
{
 if (!ReadIni()) CreateIni();
}

// Возвращает колличество зарегистрированных пользователей 

function CountUsr()
{global $RSDR,$REGF;
 if (file_exists($RSDR.$REGF)&&filesize($RSDR.$REGF)) {
  return count(explode("\n",trim(file_get_contents($RSDR.$REGF))));
 } return 0;
}

// Возвращает список зарегистрированных пользователей 

function GetUreg()
{global $RSDR,$REGF;
 if (file_exists($RSDR.$REGF)) {
  $U = explode("\n",trim(file_get_contents($RSDR.$REGF)));
  foreach ($U as &$V) {
   $P = explode("\t",$V); $V = $P[0];
  }
  return $U;
 } return null;
}

// Возвращает иформацию для конкретного зарегистрированного пользователя из базы 

function InfUreg($N)
{global $RSDR,$REGF,$PRUS;
 if (file_exists($RSDR.$REGF)) {
  $U = explode("\n",trim(file_get_contents($RSDR.$REGF)));
  foreach ($U as $V) {
   $P = explode("\t",$V); if (CompName($P[0],$N)) return explode("\t",$P[0]."\t".file_get_contents($RSDR.$PRUS.$P[1]));
  }
 } return false;
}

// Обновляет информацию для конкретного зарегистрированного пользователя в базе 

function UpdUreg($I)
{global $RSDR,$REGF,$PRUS;
 if (file_exists($RSDR.$REGF)) {
  $U = explode("\n",trim(file_get_contents($RSDR.$REGF)));
  foreach ($U as $V) {
   $P = explode("\t",$V); if ($I[0] === $P[0]) {
    $F = fopen($RSDR.$PRUS.$P[1],'wb'); fwrite($F,implode("\t",array_slice($I,1))); fclose($F); return true;
   }
  }
 } return false;
}

// Удаляет конкретного зарегистрированного пользователя из базы 

function DelUreg($N)
{global $RSDR,$REGF,$PRUS;
 if (file_exists($RSDR.$REGF)) {
  $U = explode("\n",trim(file_get_contents($RSDR.$REGF))); $i=0;
  foreach ($U as $V) {
   $P = explode("\t",$V); if ($P[0] === $N) {
    unlink($RSDR.$PRUS.$P[1]); unset($U[$i]); $F = fopen($RSDR.$REGF,'wb'); fwrite($F,implode("\n",$U)."\n"); fclose($F);
	if (filesize($RSDR.$REGF) == 1) unlink($RSDR.$REGF); return true;
   } $i++;
  }
 } return false;
}

// Чистит базу юзеров от мусора 

function ChkUreg()
{global $RSDR,$REGF,$PRUS,$OPRF; $OF = ReadIni(7);
 if (file_exists($RSDR.$REGF)) {
  $U = explode("\n",trim(file_get_contents($RSDR.$REGF))); $F = scandir($RSDR.$PRUS); $M = $U;
  foreach ($U as &$V) {
   $V = explode("\t",$V); $V = $V[1];
  } unset($V);
  foreach ($F as $V) {
   if (strpos($V,".") === false) if (!in_array($V,$U)) unlink($RSDR.$PRUS.$V);
  } unset($V);
  foreach ($M as $V) {
   $V = explode("\t",$V);
   if (!file_exists($RSDR.$PRUS.$V[1])) DelUreg($V[0]); elseif ($OF) {
    $U = InfUreg($V[0]); if ((intval((time() - $U[4])/60/60/24) > $OPRF)&&($U[5] < 2)) DelUreg($V[0]);
   }
  }
 }
}

// Проверяет на корректность email адрес 

function CheckMail($M)
{$ErrChr = array(33,34,35,36,37,38,39,40,41,42,44,47,58,59,60,61,62,63,91,92,93,94,96);
 for ($i = 0; $i < count($ErrChr); $i++)
 {
  if (strchr($M,$ErrChr[$i])) return true;
 }
 for ($i = 0; $i < strlen($M); $i++)
 {
  if (ord($M[$i]) > 122) return true;
 }
 return false;
}

// Функции для отображения даты в форме 

function DaList($D)
{$S = "";
 for ($i = 1; $i < 32; $i++) $S .= '<option'.(($D == $i) ? ' selected' : '').'>'.$i.'</option>';
 return $S;
}

function MnList($M)
{global $Month; $S = "";
 for ($i = 0; $i < count($Month); $i++) $S .= '<option'.(($M === $Month[$i]) ? ' selected' : '').'>'.$Month[$i].'</option>';
 return $S;
}

function YrList($Y)
{$D = date("Y"); $S = "";
 for ($i = 10; $i < 100; $i++) $S .= '<option'.(($Y == ($D-$i)) ? ' selected' : '').'>'.($D-$i).'</option>';
 return $S;
}

// Функция для перевода даты в цифровой формат 

function GetDfn($d,$m,$y)
{global $Month;
 for ($i = 0; $i < count($Month); $i++)
  if ($m === $Month[$i]) {
   $m = '0'.($i+1); break;
  }
 return ($d < 10 ? "0".$d : $d).".".$m.".".$y;
}

// Возвращает по имени юзера, его сессию 

function GetSusr($U)
{global $USDR,$ULDR; $M = GetAusr();
 foreach ($M as $V) {
  $S = explode("\t",file_get_contents($USDR.$ULDR.$V)); if ($S[0] === $U) return $V;
 }
 return false;
}

// Возвращает инфу пользователя из активного профиля, по его сессии 

function GetUser($id)
{global $USDR,$ULDR;
 if (GetSess($id)) return explode("\t",file_get_contents($USDR.$ULDR.$id)); else return false;
}

// Возвращает список активных сессий 

function GetAusr()
{global $USDR,$ULDR; $M = array(); $D = opendir($USDR.substr($ULDR,0,-1));
 while ($F = readdir($D)) if ((strpos($F,".") === false)&&filesize($USDR.$ULDR.$F)) array_push($M,$F);
 closedir($D); return $M;
}

// Проверка активности юзера по его сессии 

function GetSess($id)
{global $USDR,$ULDR;
 if (file_exists($USDR.$ULDR.$id)&&filesize($USDR.$ULDR.$id)) return true; else return false;
}

// Возвращает только ник юзера по его сессии 

function GetName($id)
{
 if ($M = GetUser($id)) return $M[0]; else return false;
}

// Возвращает права пользователя по его сессии 

function GetPrev($id)
{
 $M = GetUser($id); return $M[3];
}

// Проверка активности юзера по его логину, если юзер активен - возвращает активный профиль 

function CheckAusr($U)
{$M = GetAusr();
 foreach ($M as $V) {
  $V = GetUser($V); if ($U === $V[0]) return $V;
 }
 return false;
}

// Удаляет активный профиль пользователя 

function UsrDel($id)
{global $USDR,$ULDR;
 if (GetPrev($id)&&($I = InfUreg(GetName($id)))&&($U = GetUser($id))) {
  $I[4] = $U[2]; $I[11] = filemtime($USDR.$ULDR.$id)-$U[2]; UpdUreg($I);
 }
 if (file_exists($USDR.$ULDR.$id)) unlink($USDR.$ULDR.$id);
}

// Если запись устарела в бан листе, мы ее грохаем 

function ChkBan()
{global $RSDR,$BNLF;
 if (file_exists($RSDR.$BNLF)&&filesize($RSDR.$BNLF)) {
  $Mas = explode("\n",trim(file_get_contents($RSDR.$BNLF))); $F = fopen($RSDR.$BNLF,'wb');
  foreach ($Mas as $V) {
   $I = explode("\t",$V); if ($I[2] > time()) fwrite($F,$V."\n");
  }
  fclose($F);
 }
}

// Главная функция для отправки сообщений юзерам 

function WRM($M,$F,$fi = "",$li = "")
{global $USDR; $M = str_replace('~~~',date("H:i:s"),$M); $M .= '~~';
 if ($F) {
  $D = fopen($USDR.$fi,'ab'); fwrite($D,((($_SESSION['prev'] > 1)&&($_SESSION['prev'] > GetPrev($fi))) ? RepChr($M,false) : RepChr($M,true))); fclose($D);
 } else { $U = GetAusr();
  foreach ($U as $V) {
   if (($V !== $fi)&&($V !== $li)) {
    $D = fopen($USDR.$V,'ab'); fwrite($D,((($_SESSION['prev'] > 1)&&($_SESSION['prev'] > GetPrev($V))) ? RepChr($M,false) : RepChr($M,true))); fclose($D);
   }
  }
 }
}

// Функция которая ведет записи всех сообщений в лог файл 

function WRL($M)
{global $USDR,$LOGF;
 $D = fopen($USDR.$LOGF,'ab'); fwrite($D,date("d.m.Y H:i:s ").$M."\r\n"); fclose($D);
 if (filesize($USDR.$LOGF) > 1048576) {
  rename($USDR.$LOGF,$USDR.$LOGF.".tmp"); $M = array_slice(file($USDR.$LOGF.".tmp"),100); $D = fopen($USDR.$LOGF.".tmp",'wb');
  if (file_exists($USDR.$LOGF)) $M = $M.file_get_contents($USDR.$LOGF); fwrite($D,implode("",$M)); fclose($D); rename($USDR.$LOGF.".tmp",$USDR.$LOGF);
 }
}

// Вспомогательная функция для информации о пользователе 

function InfPrv($P)
{
 switch ($P) {
  case 0 : return 'Гость';
  case 1 : return 'Пользователь';
  case 2 : return 'Администратор';
  case 3 : return 'Главный';
 }
}

// Проверяет строку на наличие длинных слов 

function CheckSpace($M)
{$M = explode(" ",Pms($M));
 foreach ($M as $V) if (strlen($V) > 30) return true;
 return false;
}

// Заменяет символы, понятно зачем:-) 

function RepChr($S,$F)
{$M = array("\"" => "&#34","'" => "&#39;","\\" => "&#92;","<" => "&#60;",">" => "&#62;");
 if ($F) while (list($K,$V) = each($M)) $S = str_replace($K,$V,$S); else $S = addslashes(str_replace("<","<~|",$S));
 return $S;
}

// Возвращает оставшееся время в нужном формате 

function TmlInf($T)
{
 return (intval(($T - time())/60/60/24) ? intval(($T - time())/60/60/24).' д. ' : '').((($T - time())/60/60%24) ? (($T - time())/60/60%24).' ч. и ' : '').((($T - time())/60%60) ? (($T - time())/60%60).' мин' : ' несколько секунд');
}

?>