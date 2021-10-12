<?php
session_start();
require('dbconnect.php');

if ($_COOKIE['email'] !== '') {
  $email = $_COOKIE['email'];
}

// POSTの値が入っていたら
if (!empty($_POST)) {
  $email = $_POST['email'];

  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $member = $login->fetch();

    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      if ($_POST['save'] === 'on') {
        setcookie('email', $_POST['email'], time()+60*60*24*14);
      }

      header('Location: index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登山道具重さ計算ツール</title>
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/c09da6029c.js" crossorigin="anonymous"></script>
  <!-- Font -->
</head>

<body>
  <div class="container">
    <header class="header">
      <div class="header__inner">
        <a class="header__title" href="#">
          <h1><img src="images/mountain-icon.svg" alt="">重さ計算ツール</h1>
        </a>
      </div><!-- header__inner -->
    </header>

    <main>
      <section class="login">
        <h2 class="title_left">ログインする</h2>
        <div class="to_register">
          <p class="to_register__text">＊入会手続きがまだの方はこちらからどうぞ</p>
          <a class="btn btn_md btn_green" href="join/">入会手続きをする</a>
        </div><!-- .to_login_box -->
        <form class="login__form" action="" method="post">
          <dl>
            <div class="form_container">
              <dt><label for="email">Eメール：</label></dt>
              <dd>
                <input type="text" id="email" name="email" maxlength="255" value="<?php print(htmlspecialchars($email, ENT_QUOTES)); ?>">
                <?php if ($error['login'] === 'blank') : ?>
                  <p class="error">* メールアドレスとパスワードを入力してください</p>
                <?php endif; ?>
                <?php if ($error['login'] === 'failed') : ?>
                  <p class="error">* ログインに失敗しました。<br>メールアドレスとパスワードを正しく入力してください</p>
                <?php endif; ?>
              </dd>
            </div><!-- form_container -->

            <div class="form_container">
              <dt><label for="password">パスワード：</label></dt>
              <dd>
                <input type="password" name="password" id="password" maxlength="100" value="<?php print(htmlspecialchars($_POST['password'], ENT_QUOTES)); ?>">
              </dd>
            </div><!-- form_container -->
            <input class="checkbox" type="checkbox" id="save" name="save" value="on">
            <label class="checkbox__text" for="save">次回からは自動的にログインする</label>
          </dl>
          <input type="submit" class="btn btn_md btn_bl " value="ログインする">
        </form>
      </section><!-- login -->

    </main>
  </div><!-- .container -->

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>

</body>

</html>