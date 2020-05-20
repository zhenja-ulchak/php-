<?php
 class info{
    private $message;
    public function message($mess){
        // передаєм параметри 
      $this->message = $message;
    //   шукаєм текст preg_match(1шобудем шукати ,2 дебудем шукати)
      $record = preg_match("/[Hello]/",$this->message);
    //   перевиряєи на истиность  $record
      try{
        if(!$record)
            throw new Exception("текста нема");
        else
        return "ви вели хело";
        // исключениє
      }catch(Exception $e){
          return $e->getMessage();
      }  
    }
}
$info = new Info();
// если переменна $_GET['message'] є то ми присвоюємо $_GET['message'] инакше фолс
$imessage = $_GET['message']?$_GET['message'] : false;
print $info->message($imessage);



// Исключения — это гибкий, расширяемый метод обработки ошибок;

// Это стандартизованный механизм – человеку, не работавшему 
// с вашим кодом, не нужно будет читать мануал, чтобы понять,
//  как обрабатывать ошибки. Ему достаточно знать, как работают
//  лючения;

// С исключениями гораздо проще находить источник ошибок, 
// так как всегда есть стек вызовов (trace).




// //Пробуем (try) что-либо сделать.
// try{
//     //Очевидно, 1 никогда не будет равняться 2...
//     if(1 !== 2){
//         //Генерируем исключение.
//         throw new Exception('1 не равняется 2!');
//     }
// } 
// //Перехватываем (catch) исключение, если что-то идет не так.
// catch (Exception $ex) {
//     //Выводим сообщение об исключении.
//     echo $ex->getMessage();




// наследуэм новое исключениэ
class ExtFiles extends Exception{
    private $errorName;
    // робим конструкцию 
    function __construct($error){
        $this->errorName = $error;

    }
    // функция вивода результата ошибки
    function result(){
        // вертаэм 
        return "ошибка\n".$this->errorName."\nстрока:\n";

    }
}
// робим тоже для бази
 class Extdb extends Exception{
    private $errorName;
    function __construct($error){
        $this->errorName = $error;

    }
    function result(){
        return "ошибка\n".$this->errorName."\nстрока:\n";

    }  
 }
 class A {
     private $base;
    //  перевиряэм через функцию getConnect($file, $db)
     public function getConnect($file, $db){
         try{
            //  новоэ исключениэ throw new ExtFiles
             if (!file_exists($file)) {
                throw new ExtFiles("Error Processing Request Файл не найден");
                  
             }else {
                 print file_get_contents($file);
             }
            //  db
            if (!mysqli_connect('localhost','root','')) {
                throw new ExtDB("Error: ошыбка при соединении с базой даних......... " );  
            }elseif (!mysqli_select_db($db)) {
                throw new ExtDB("Error: ошыбка при подключении с базой даних ......." );
                
            }
         }catch(ExtFiles $e){
            return $e->result().$e->getLine();
         }catch(ExtDB $e){
            return $e->result().$e->getLine(); 
         }
     } 
 }
$a = new A();
print $a->getConnect('text.txt', 'taskkk');

// getMessage() - вертаэ строку передану конструктору
// getCode() - вертає код ошибки переданцу в конструктор
// getFile() - вертає имя файла в якому було сгенерировано исключениє
// getLine() - вертає номер строки в якому було сгенерировано исключениє






?>