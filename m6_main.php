<link rel="stylesheet" href="m6_style.css">
<?php
  session_start();
  require_once "m6_db.php";

  if (!isset($_SESSION["user_id"])) {
      
      echo "ログインしてください";
      exit;
      
  }
  
  $sql = "SELECT * FROM users WHERE id = :id";
  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(":id", $_SESSION["user_id"], PDO::PARAM_INT);
  $stmt->execute();
  $user = $stmt->fetch();
  
?>

<h1>就活情報共有サービス　就勝つ掲示板</h1>

<p><?php echo $user["name"]; ?>さん、ようこそ！</p>

<a href="m6_post.php">就活情報を投稿する</a>
<br>
<a href="m6_posts.php">就活情報を見る　検索する</a>
