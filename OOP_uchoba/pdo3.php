<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=slon",'root','');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $id = 1;
    $name = 'STAS';

    $sql = $conn->prepar("SELECT * FROM users WHERE id = :id AND name = :name");
    $sql->bindParam(':id',$id, PDO::PARAM_INT);
    $sql->bindParam(':name', $name, PDO::PARAM_STR);
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);


echo $result[''] //рядок який шукаэм 
} catch (PDOException $e) {
    echo "ошибка";
    file_put_contents('error.txt'.$e->getMessage());
}


// ':id'
// Идентификатор параметра. Для подготавливаемых запросов с именованными параметрами это будет имя в виде :name. Если используются неименованные параметры (знаки вопроса ?) это будет позиция псевдопеременной в запросе (начиная с 1).

// $id
// Имя PHP переменной, которую требуется привязать к параметру SQL запроса.

// PDO::PARAM_INT
// Явно заданный тип данных параметра. Тип задается одной из констант PDO::PARAM_*. Если параметр используется в том числе для вывода информации из хранимой процедуры, к значению аргумента data_type необходимо добавить PDO::PARAM_INPUT_OUTPUT, используя оператор побитовое ИЛИ.

// length
// Размер типа данных. Чтобы указать, что параметр используется для вывода данных из хранимой процедуры, необходимо явно задать его размер.

?>