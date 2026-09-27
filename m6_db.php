<?php
#TABLE作成
  $dsn = 'mysql:dbname=データベース名;host=localhost';
  $user = 'ユーザ名';
  $password = 'パスワード';
  $pdo = new PDO($dsn, $user, $password, 
  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>