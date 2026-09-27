<link rel="stylesheet" href="m6_style.css">
<h1>さあ！ログインして始めよう！</h1>
<?php
  session_start();
  require_once "m6_db.php";
?>  

<form action = "" method = "post" >
    <input type = "email" name = "email" placeholder = "メールアドレスを入力">
    <input type = "password" name = "password" placeholder = "パスワードを入力">
    <input type = "submit" name = "submit" value = "ログイン">
</form>

<p>
    アカウントをお持ちでない方は
    <a href="m6_register.php">新規登録</a>
</p>

<?php
  if (isset($_POST["submit"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
      
      $email = $_POST["email"];
      $password = $_POST["password"];
      
      $sql = "SELECT * FROM users WHERE email = :email";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(":email", $email, PDO::PARAM_STR);
      
      $stmt->execute();
      
      $row = $stmt->fetch();
      
      if ($row) {
          
          if ($password == $row["password"]) {
              $user_id = $row["id"];
              $_SESSION["user_id"] = $user_id;
              header("Location: m6_main.php");
              exit;
          }
          else{
              echo "メールアドレスまたはパスワードが違います";
          }
      
      }
      else{
          echo "メールアドレスまたはパスワードが違います";
      }
      
  }
?>  