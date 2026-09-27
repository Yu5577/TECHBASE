<link rel="stylesheet" href="m6_style.css">
<?php
  session_start();
  require_once "m6_db.php";

  if (!isset($_SESSION["user_id"])) {
      echo "ログインしてください";
      exit;
  }
  
  
   // 検索されたかどうかを確認
  if (isset($_POST["search_submit"])) {
    $search = "%" . $_POST["search"] . "%";
    $sql = "SELECT posts.*, users.name
              FROM posts
              JOIN users ON posts.user_id = users.id
              WHERE posts.company LIKE :search";
              
              
    $category = $_POST["category"];
    // カテゴリが選択されていたら条件を追加
      if (!empty($category)) {
          $sql .= " AND posts.category = :category";
      }

      $sql .= " ORDER BY posts.id DESC";

      
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":search", $search, PDO::PARAM_STR);
    
    // カテゴリが選択されていた場合だけ渡す
      if (!empty($category)) {
          $stmt->bindParam(":category", $category, PDO::PARAM_STR);
      }
      
  }
  else {
  
  $sql = "SELECT posts.*, users.name
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.id DESC";
        $stmt = $pdo->prepare($sql);
  }
  $stmt->execute();
?>

<form action="" method="post">

    <input type="text" name="search" placeholder="企業名を入力">

    <select name="category">
        <option value="">カテゴリを選択</option>
        <option value="面接">面接</option>
        <option value="ES">ES</option>
        <option value="説明会">説明会</option>
        <option value="インターン">インターン</option>
        <option value="その他">その他</option>
    </select>

    <input type="submit" name="search_submit" value="検索">

</form>


  
<?php
  $count = 0;
  
  while ($row = $stmt->fetch()) {
      
      $count++;
      echo '<div class="post">';
      echo "<hr>";
      echo "投稿者：" . $row["name"] . "さん<br>";
      echo "企業名：" . $row["company"] . "<br>";
      echo "カテゴリ：" . $row["category"] . "<br>";
      echo "タイトル：" . $row["title"] . "<br>";
      echo "内容：" . $row["comment"] . "<br>";
      echo "投稿日時：" . $row["created_at"] ;
      echo "<hr>";
      echo '</div>';
      
  if ($_SESSION["user_id"] == $row["user_id"]) {

    echo '<div class="post-actions">';
    
    echo "上記の投稿はあなたの投稿なので編集削除が可能です";
    
    echo '<form action="m6_edit.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
    echo '<input type="password" name="password" placeholder="パスワード">';
    echo '<input type="submit" name="edit" value="編集">';
    echo '</form>';

    echo '<form action="m6_delete.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $row["id"] . '">';
    echo '<input type="password" name="password" placeholder="パスワード">';
    echo '<input type="submit" name="delete" value="削除">';
    echo '</form>';
    
    echo "<hr>";


    echo '</div>';
}

      
  }
  
  if ($count == 0) {
    echo "該当する投稿はありません。</br>";
}

  
  
  
?>

<a href="m6_main.php">メインページに戻る</a>