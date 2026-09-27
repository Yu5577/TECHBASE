<?php
session_start();
require_once "m6_db.php";

if (!isset($_SESSION["user_id"])) {
    echo "ログインしてください";
    exit;
}

if (isset($_POST["edit"])) {

    $post_id = $_POST["id"];
    $password = $_POST["password"];
    $user_id = $_SESSION["user_id"];

    // ユーザーのパスワードを取得
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

    // 自分の投稿を取得
    $sql = "SELECT * FROM posts
            WHERE id = :post_id
            AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $post = $stmt->fetch();

    if (!$post) {
        echo "この投稿は編集できません。";
        exit;
    }
}


  if (isset($_POST["update"])) {

    $post_id = $_POST["id"];
    $company = $_POST["company"];
    $category = $_POST["category"];
    $title = $_POST["title"];
    $comment = $_POST["comment"];
    $user_id = $_SESSION["user_id"];

    $sql = "UPDATE posts
            SET company = :company,
                category = :category,
                title = :title,
                comment = :comment
            WHERE id = :post_id
            AND user_id = :user_id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":company", $company, PDO::PARAM_STR);
    $stmt->bindParam(":category", $category, PDO::PARAM_STR);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
    $stmt->bindParam(":post_id", $post_id, PDO::PARAM_INT);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

    $stmt->execute();

    echo "投稿を更新しました！";
}
?>

<h2>投稿を編集</h2>

<form action="m6_edit.php" method="post">

    <input type="hidden" name="id" value="<?php echo $post["id"]; ?>"  >

    <input type="text" name="company"
           value="<?php echo $post["company"]; ?>" placeholder ="企業名を入力">
    <br>

    <input type="text" name="category"
           value="<?php echo $post["category"]; ?>"placeholder ="カテゴリを入力">
    <br>

    <input type="text" name="title"　
     value="<?php echo $post["title"]; ?>"placeholder ="タイトルを入力">
    <br>

    <textarea name="comment" rows="10" cols="50"placeholder = "内容を入力"><?php echo $post["comment"];?></textarea>
    <br>

    <input type="submit" name="update" value="更新">

</form>

<a href="m6_posts.php">投稿一覧に戻る</a>