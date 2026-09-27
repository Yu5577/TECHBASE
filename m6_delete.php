<?php
session_start();
require_once "m6_db.php";

if (!isset($_SESSION["user_id"])) {
    echo "ログインしてください";
    exit;
}

if (isset($_POST["delete"])) {

    $post_id = $_POST["id"];
    $password = $_POST["password"];
    $user_id = $_SESSION["user_id"];

    // ログイン中のユーザーのパスワードを取得
    $sql = "SELECT password FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch();

    // パスワード確認
    if ($password != $user["password"]) {
        echo "パスワードが違います。";
        exit;
    }

    // 自分の投稿だけ削除
    $sql = "DELETE FROM posts 
            WHERE id = :post_id 
            AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    echo "投稿を削除しました。";
}
?>

<a href="m6_posts.php">投稿一覧に戻る</a>