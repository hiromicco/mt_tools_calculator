<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
  $_SESSION['time'] = time();

  $members = $db->prepare('SELECT * FROM members WHERE id=?');
  $members->execute(array($_SESSION['id']));
  $member = $members->fetch();
} else {
  header('Location: login.php');
  exit();
}

if (!empty($_POST)) {
  if ($_POST['category'] !== '' && $_POST['tool_name'] !== '' && $_POST['weight'] !== '') {
    $tool = $db->prepare('INSERT INTO tools SET category=?, tool_name=?, weight=?, member_id=?, created=NOW()');
    $tool->execute(array(
      $_POST['category'],
      $_POST['tool_name'],
      $_POST['weight'],
      $member['id']
    ));

    header('Location: index.php');
    exit();
  }
}
$tools = $db->prepare('SELECT t.* FROM tools t, members m WHERE t.member_id=m.id AND m.id=?');
$tools->execute(array($member['id']));
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登山道具重さ計算ツール</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
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
        <div class="header__btns">
          <a class="btn btn_sm" href="logout.php">ログアウト</a>
          <a class="btn btn_md btn_gr" href="select.php?id=<?php print(htmlspecialchars($member['id'], ENT_QUOTES)); ?>">重さを計算してみる ≫</a>
        </div><!-- .header__btns -->
      </div><!-- .header__inner -->
    </header>

    <main>
      <section class="tool_register">
        <h2 class="title_left">
          <!-- <span class='user_name'><?php print(htmlspecialchars($member['name'], ENT_QUOTES)); ?>'s　</span> -->
          登山ツールを登録する
        </h2>
        <form action="" method="post">
          <dl>
            <div class="form_container">
              <dt><label for="category">カテゴリー：</label></dt>
              <dd><select name="category" id="category">
                  <option value="登山用具">登山用具</option>
                  <option value="バックパック">バックパック</option>
                  <option value="テント">テント</option>
                  <option value="シュラフ・マット">シュラフ・マット</option>
                  <option value="調理器具">調理器具</option>
                  <option value="飲食物">飲食物</option>
                  <option value="衣類">衣類</option>
                  <option value="生活・衛生">生活・衛生</option>
                  <option value="サコッシュ">サコッシュ</option>
                </select></dd>
            </div><!-- form_container -->

            <div class="form_container">
              <dt><label for="name">品名：</label></dt>
              <dd><input type="text" name="tool_name" id="name"></dd>
            </div><!-- form_container -->
            <div class="form_container">
              <dt><label for="weight">重さ：</label></dt>
              <dd><input type="number" name="weight" id="weight"> g</dd>
            </div><!-- form_container -->
          </dl>
          <input class="btn btn_bl btn_md tool_register__btn" type="submit" value="登録する">
        </form>
      </section><!-- tool_register -->

      <section class="tool_list">
        <h2 class="title_center">My 登山ツール</h2>
        <table>
          <tr>
            <th>カテゴリー</th>
            <th>品名</th>
            <th>重さ</th>
            <th></th>
          </tr>
          <tr>
            <?php foreach ($tools as $tool) : ?>
              <td><?php print(htmlspecialchars($tool['category'], ENT_QUOTES)); ?></td>
              <td><?php print(htmlspecialchars($tool['tool_name'], ENT_QUOTES)); ?></td>
              <td><?php print(htmlspecialchars($tool['weight'], ENT_QUOTES)); ?>&nbsp;g</td>
              <td><a class="delete_link" href="delete.php?id=<?php print(htmlspecialchars($tool['id'], ENT_QUOTES)); ?>" class='delete'> × </a></td>
          </tr>
        <?php endforeach; ?>
        </table>
      </section><!-- tool_list -->
    </main>
  </div><!-- .container -->

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>

</body>

</html>