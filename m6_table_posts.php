<?php
#TABLE作成
  $dsn = 'mysql:dbname=データベース名;host=localhost';
  $user = 'ユーザ名';
  $password = 'パスワード';
  $pdo = new PDO($dsn, $user, $password, 
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  
  $sql = "CREATE TABLE IF NOT EXISTS posts"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "user_id INT,"
        . "company VARCHAR(100),"
        . "category VARCHAR(50),"
        . "title VARCHAR(100),"
        . "comment TEXT,"
        . "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        .")";
  $stmt = $pdo->query($sql);
?>