<?php 
session_start();
require('../dbconnect.php');

if (!isset($_SESSION['join'])) {
  header('Location: index.php');
  exit();
}

if (!empty($_POST)) {
  $statement = $db->prepare('INSERT INTO members SET name=?, email=?, password=?, created=NOW()');
  echo $statement->execute(array(
    $_SESSION['join']['name'],
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['password'])
  ));

  unset($_SESSION['join']);

  header('Location: thanks.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登山道具重さ計算ツール</title>
  <link rel="stylesheet" href="../css/reset.css">
  <link rel="stylesheet" href="../css/join.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/c09da6029c.js" crossorigin="anonymous"></script>
  <!-- Font -->
</head>

<body>
  <div class="container">
    <header>
      <div class="header_container">
        <a class="site_title" href="#">
          <h1><img src="../images/mountain-icon.svg" alt="">重さ計算ツール</h1>
        </a>
      </div><!-- header_container -->
    </header>

    <main>
      <section class="mytool_register">
        <h2>会員登録する</h2>
        <form action="" method="post">
          <input type="hidden" name="action" value="submit">
          <dl>
            <div class="tool_property">
              <dt><label for="category">名前：</label></dt>
              <dd><?php print(htmlspecialchars($_SESSION['join']['name'])); ?></dd>
            </div><!-- tool_property -->

            <div class="tool_property">
              <dt><label for="name">メール：</label></dt>
              <dd><?php print(htmlspecialchars($_SESSION['join']['email'])); ?></dd>
            </div><!-- tool_property -->

            <div class="tool_property">
              <dt><label for="weight">パスワード：</label></dt>
              <dd>【表示されません】</dd>
            </div><!-- tool_property -->
          </dl>
        </section><!-- mytool_register -->
        <div class="btn_box">
          <a class="check_btn return_btn" href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
          <input class="check_btn confirm_btn" type="submit" value="登録する" />
        </div><!-- .btn_box -->
      </form>
    </main>
  </div><!-- .container -->

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>

</body>

</html>