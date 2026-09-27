<?php
session_start();

require_once "m6_db.php";
require_once "m6_table_users.php";
require_once "m6_table_posts.php";

if (isset($_POST["submit"]) && 
    !empty($_POST["name"]) && 
    !empty($_POST["email"]) && 
    !empty($_POST["password"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);

    $stmt->execute();

    // 登録後にログイン画面へ
    header("Location: m6_login.php");
    exit;
}
?>

<link rel="stylesheet" href="m6_style.css">

<h1>ようこそ！<br>まずは新規登録をしよう</h1>

<form action="" method="post">

    <input type="text" name="name" placeholder="名前を入力">

    <input type="email" name="email" placeholder="メールアドレスを入力">

    <input type="password" name="password" placeholder="パスワードを入力">

    <input type="submit" name="submit" value="送信">

</form>