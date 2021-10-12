<?php
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
  if ($_POST['name'] === '') {
    $error['name'] = 'blank';
  }
  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  if (strlen($_POST['password']) < 4) {
    $error['password'] = 'length';
  }
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }

  // アカウントの重複をチェック
  if (empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }

  if (empty($error)) {
    $_SESSION['join'] = $_POST;
    header('Location: check.php');
    exit();
  }
}
if ($_REQUEST['action'] == 'rewrite' && isset($_SESSION['join'])) {
  $_POST = $_SESSION['join'];
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
  <link rel="stylesheet" href="../css/style.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/c09da6029c.js" crossorigin="anonymous"></script>
  <!-- Font -->
</head>

<body>
  <div class="container">
    <header class="header">
      <div class="header__inner">
        <a class="header__title" href="#">
          <h1><img src="../images/mountain-icon.svg" alt="">重さ計算ツール</h1>
        </a>
      </div><!-- header_container -->
    </header>

    <main>
      <section class="register content_pd">
        <h2 class="title_left">会員登録する</h2>
        <form action="" method="post" enctype="multipart/form-data">
          <dl>
            <div class="form_container">
              <dt><label for="name">名前：</label></dt>
              <dd>
                <input type="text" name="name" id="name" maxlength="255" value="<?php print(htmlspecialchars($_POST['name'], ENT_QUOTES)); ?>">
                <?php if ($error['name'] === 'blank') : ?>
                  <p class="error">* 名前を入力してください</p>
                <?php endif; ?>
              </dd>
            </div><!-- form_container -->

            <div class="form_container">
              <dt><label for="email">メール：</label></dt>
              <dd>
                <input type="text" id="email" name="email" maxlength="255" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
                <?php if ($error['email'] === 'blank') : ?>
                  <p class="error">* Eメールアドレスを入力してください</p>
                <?php endif; ?>
                <?php if ($error['email'] === 'duplicate') : ?>
                  <p class="error">* 指定されたEメールアドレスは<br>　すでに登録されています</p>
                <?php endif; ?>
              </dd>
            </div><!-- form_container -->

            <div class="form_container">
              <dt><label for="password">パスワード：</label></dt>
              <dd>
                <input type="password" name="password" id="password" maxlength="100" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
                <?php if ($error['password'] === 'length') : ?>
                  <p class="error">* パスワードは4文字以上で入力してください</p>
                <?php endif; ?>
                <?php if ($error['password'] === 'blank') : ?>
                  <p class="error">* パスワードを入力してください</p>
                <?php endif; ?>
              </dd>
            </div><!-- form_container -->
          </dl>
          <input class="btn btn_md btn_bl" type="submit" value="入力内容を確認する">
        </form>
      </section><!-- register -->

    </main>
  </div><!-- .container -->

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>

</body>

</html>