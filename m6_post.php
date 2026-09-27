<link rel="stylesheet" href="m6_style.css">
<?php
  session_start();
  require_once "m6_db.php";

  if (!isset($_SESSION["user_id"])) {
      echo "ログインしてください";
      exit;
      
  }
?>

<form action="" method="post">
    <input type="text" name="company" placeholder="企業名　例：○○株式会社">
    <br>
    <input type="text" name="category" placeholder="カテゴリ 例：面接">
    <br>
    <input type="text" name="title" placeholder="タイトル　例：一次面接">
    <br>
    <textarea name="comment" rows="10" cols="50" placeholder="就活情報を入力　例：穏やかな雰囲気"></textarea>
    <br>
    <input type="submit" name="submit" value="投稿">
</form>

<?php
  if (isset($_POST["submit"]) && !empty($_POST["company"])  && !empty($_POST["title"]) && !empty($_POST["comment"])) {
      
       $company = $_POST["company"];
       $category = $_POST["category"];
       $title = $_POST["title"];
       $comment = $_POST["comment"];
       
       $user_id = $_SESSION["user_id"];
       
       $sql = "INSERT INTO posts (user_id, company, category, title, comment) VALUES (:user_id, :company, :category, :title, :comment)";
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
       $stmt->bindParam(':company', $company, PDO::PARAM_STR);
       $stmt->bindParam(':category', $category, PDO::PARAM_STR);
       $stmt->bindParam(':title', $title, PDO::PARAM_STR);
       $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
       
       $stmt->execute();
       
       echo "投稿ありがとう！あなたの投稿が誰かの役に立ちます";
       
       
  }
?>  
<br>
<a href="m6_main.php">メインページに戻る</a>
 