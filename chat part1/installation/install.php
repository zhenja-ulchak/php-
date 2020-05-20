<?php
header('Content-type:text/html; charset=utf-8');

class Install{
    private $_db;
    private $path;
    const DB_INSTALL = "chat.db";
    function __construct(){
        $this->path = "../db/";
        // file_exists - перевіряє чи існує файл
        if (!file_exists($this->path.self::DB_INSTALL)) {
            // то создає нову базу (файл)
            try {
                // new SQliteDatabase($this->path.self::DB_INSTALL то шо створює новий файл
                $this->_db = new SQLite3($this->path.self::DB_INSTALL);
                $sql_users = "CREATE TABLE users(
                             id INTEGER PRIMARY KEY,
                             login TEXT,
                             name TEXT,
                             email TEXT,
                             password TEXT,
                             access INTEGER,
                             age INTEGER,
                             gender TEXT,
                             date TEXT ) ";
                 $sql_messages = "CREATE TABLE message(
                    id INTEGER PRIMARY KEY,
                            userid INTEGER,
                            roomid INTEGER,
                            messages TEXT,
                            date TEXT)";
                 $sql_room = "CREATE TABLE room(
                            id INTEGER PRIMARY KEY,
                            userid INTEGER,
                            title TEXT,
                            description TEXT)";
                // робим запрос через премену
                // 
                $mz_users = $this->_db->query( $sql_users);
                $mz_messeges = $this->_db->query($sql_messeges);
                $mz_room = $this->_db->query($sql_room);
                // єсли не предасть створює нове исключениє в виді ошибки
                if (!$mz_users)
                    throw new SQLiteException(sqlite_error_string($this->_db->last_error()));
                if(!$mz_messeges)
                    throw new SQLiteException(sqlite_error_string($this->_db->last_error()));
                if(!$mz_room)
                    throw new SQLiteException(sqlite_error_string($this->_db->last_error()));   
                
            } 
            // ловим ошибку и вертаєм її
            catch (SQLiteException $e) {
               return "Error:\n".$e->getMessage();
                   
            }
        }else{
            // $this->path.self::DB_INSTALL указуєм путь до файлаєсли вин вже созданий
            $this->_db = new SQLite3($this->path.self::DB_INSTALL);
            die("чат вже установлений удалите инстал"); 
        }
    }

    public function getDBAdmin($login, $password){
        // $clear = sqlite_escape_string($login);
        $date = time();
        try{
             $sql_admin = "INSERT INTO users(id,login,password,access,date)
                            VALUES('1','$login','$password','1','$date')";
            //  $_mzChat = $this->_db->query($sql_admin);
            //  if (!$_msChat) 
            //     throw new SQLiteException(sqlite_error_string($this->_db->last_error()));
            //  else 
            //      return true;
             
             
            }catch (SQLiteException $e) {
                return "Error:\n".$e->getMessage();
                    
             }
    }
    function __destruct(){
        unset($this->_db);
        if (!file_exists($this->path.self::DB_INSTALL)); 
        else unlink($this->path.self::DB_INSTALL);
        
    }
}






?>