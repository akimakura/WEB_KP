<?php

session_start();
require('connect.php');

function tt($value)
{
    echo '<pre>';
    print_r($value);
    echo '<pre>';
}

// Выполн запрос к бд
function dbCheckError($query)
{
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE){
        echo $errInfo[2];
        exit();
    }
    return true;
}


// Получ данных c 1 табл
function selectAll($table, $conditions = []) {
    global $pdo;
    $sql = "SELECT * FROM $table";

    if (!empty($conditions)) {
        $i = 0;
        $params = [];
        foreach ($conditions as $key => $value) {
            if ($key === 'OR') {
                $sql .= " WHERE (";
                foreach ($value as $orKey => $orValue) {
                    if ($i > 0) {
                        $sql .= " OR ";
                    }
                    $sql .= "$orKey LIKE :$orKey";
                    $params[$orKey] = $orValue;
                    $i++;
                }
                $sql .= ")";
            } else {
                if ($i === 0) {
                    $sql .= " WHERE $key = :$key";
                } else {
                    $sql .= " AND $key = :$key";
                }
                $params[$key] = $value;
                $i++;
            }
        }
    }

    $stmt = $pdo->prepare($sql);
    foreach ($params as $key => $value) {
        $stmt->bindValue(':'.$key, $value);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Получение одной строки из таблицы
function selectOne($table, $params = [])
{
    global $pdo;
    $sql = "SELECT * FROM $table";
    if(!empty($params)){
        $i = 0;
        foreach ($params as $key => $value){
            if ($i === 0){
                $sql = $sql . " WHERE $key = :$key";
            } else {
                $sql = $sql . " AND $key = :$key";
            }
            $i++;
        }
    }
    $query = $pdo->prepare($sql);
    $query->execute($params);  // передача ассоциативного массива с параметрами
    dbCheckError($query);
    return $query->fetch();
}
// Эта функция принимает ассоциативный массив $params, где ключи соответствуют именам столбцов
// в базе данных, а значения — значениям для поиска. В SQL-запросе используются именованные параметры, 
// которые заменяются перед выполнением запроса.
//$params = ['surname' => 'Riyb'];


// Запись в таблицу в бд
function insert($table, $params)
{
    global $pdo;
    $columns = implode(", ", array_keys($params));
    $values = ":" . implode(", :", array_keys($params));

    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    $query = $pdo->prepare($sql);

    foreach ($params as $key => $value) {
        $query->bindValue(":$key", $value);
    }

    $query->execute();
    dbCheckError($query);
    return $pdo->lastInsertId();
}
//$arrData = [
//    'name' => 'Gusia',
//    'surname' => 'Jigurda',
//    'phone_num' => '79903335665',
//    'email' => 'pgpgpg@mail.ru'
//];
//insert('contacts', $arrData);


// обнов строки
function update($table, $id_name, $id, $params)
{
    global $pdo;
    $str = '';
    $i = 0;
    foreach ($params as $key => $value) {
        $str .= ($i === 0) ? "$key = :$key" : ", $key = :$key";
        $i++;
    }
    $sql = "UPDATE $table SET $str WHERE $id_name = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id', $id);
    foreach ($params as $key => $value) {
        $query->bindValue(":$key", $value);
    }
    $query->execute();
    dbCheckError($query);
}
//$params = ['name' => 'N', 'surname' => 'Mister'];
//update('contacts', 'contacts_id', 2, $params);


// удаление строки
function delete($table, $conditions) {
    global $pdo;
    $sql = "DELETE FROM $table WHERE ";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql .= "$key = :$key";
        } else {
            $sql .= " AND $key = :$key";
        }
        $i++;
    }

    $stmt = $pdo->prepare($sql);
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        die("Ошибка удаления записи: " . $e->getMessage());
    }
}
//delete('contacts', 'contacts_id', 1);




// Добавление временного окна
function addTimeWindow($instructor_id, $start_time, $end_time, $max_slots) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO time_window (instructor_id, start_time, end_time, max_slots) VALUES (:instructor_id, :start_time, :end_time, :max_slots)");
    $stmt->execute([
        'instructor_id' => $instructor_id,
        'start_time' => $start_time,
        'end_time' => $end_time,
        'max_slots' => $max_slots
    ]);
}

// Получение всех временных окон инструктора
function getTimeWindows($instructor_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT time_window_id, start_time, end_time, max_slots FROM time_window WHERE instructor_id = :instructor_id");
    $stmt->execute(['instructor_id' => $instructor_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Запись на время
function bookTime($user_id, $instructor_id, $start_time, $end_time)
{
    global $pdo;
    $sql = "INSERT INTO bookings (user_id, instructor_id, start_time, end_time) VALUES (:user_id, :instructor_id, :start_time, :end_time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'user_id' => $user_id,
        'instructor_id' => $instructor_id,
        'start_time' => $start_time,
        'end_time' => $end_time
    ]);
    dbCheckError($stmt);
}



function selectAllInstructorsWithNames() {
    global $pdo;
    $sql = "SELECT i.instructor_id, u.name, u.surname 
            FROM instructor i 
            JOIN users u ON i.users_id = u.users_id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}


function deleteTimeWindow($time_window_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM time_window WHERE time_window_id = :time_window_id");
    $stmt->execute(['time_window_id' => $time_window_id]);
}

