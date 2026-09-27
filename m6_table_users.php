<?php
#TABLE作成
  $dsn = 'mysql:dbname=データベース名;host=localhost';
  $user = 'ユーザ名';
  $password = 'パスワード';
  $pdo = new PDO($dsn, $user, $password, 
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  
  $sql = "CREATE TABLE IF NOT EXISTS users"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name CHAR(32),"
        . "email TEXT,"
        . "password TEXT"
        .")";
 
  $stmt = $pdo->query($sql);
?>