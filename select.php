<?php
session_start();
require('dbconnect.php');

if (empty($_REQUEST['id'])) {
  header('Location: index.php');
  exit();
}

$_SESSION['id'] = $_REQUEST['id'];

$tools = $db->prepare('SELECT t.* FROM tools t, members m WHERE t.member_id=m.id AND m.id=?');
$tools->execute(array($_REQUEST['id']));

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>登山道具重さ計算ツール</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/select.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/c09da6029c.js" crossorigin="anonymous"></script>
  <!-- Font -->
</head>

<body>
  <div class="container">
    <header>
      <div class="container">
        <h1 class="site_title"><img src="images/mountain-icon.svg" alt="">重さを計算する</h1>
      </div><!-- container -->
    </header>

    <main>
      <section class="select_mytool">
        <h2>今回持っていく道具</h2>
        <p class="lead">持っていく道具を選んで <i class="fas fa-check"></i>マークをいれてください</p>
        <form action="result.php" method="post">
          <table>
            <tr>
              <th><input type="checkbox" name="select" value="" checked="checked"></th>
              <th>カテゴリー</th>
              <th>　　　品名　　　</th>
              <th>　重さ　</th>
            </tr>
            <?php foreach ($tools as $tool) : ?>
              <tr>
                <td><input type="checkbox" name="select[<?php print(htmlspecialchars($tool['tool_name'], ENT_QUOTES)); ?>]" value="<?php print(htmlspecialchars($tool['weight'], ENT_QUOTES)); ?>"></td>
                <td><?php print(htmlspecialchars($tool['category'], ENT_QUOTES)); ?></td><input type="hidden" name="category[<?php print(htmlspecialchars($tool['tool_name'], ENT_QUOTES)); ?>]" value="<?php print(htmlspecialchars($tool['category'], ENT_QUOTES)); ?>">
                <td><?php print(htmlspecialchars($tool['tool_name'], ENT_QUOTES)); ?></td><input type="hidden" name="tool_name[<?php print(htmlspecialchars($tool['tool_name'],ENT_QUOTES)); ?>]" value="<?php print(htmlspecialchars($tool['tool_name'], ENT_QUOTES)); ?>">
                <td><?php print(htmlspecialchars($tool['weight'], ENT_QUOTES)); ?>g</td><input type="hidden" name="weight[<?php print(htmlspecialchars($tool['tool_name'], ENT_QUOTES)); ?>]" value="<?php print(htmlspecialchars($tool['weight'], ENT_QUOTES)); ?>">
              </tr>
            <?php endforeach; ?>
          </table>
          <input class="calculate_btn" type="submit" value="これに決めた！">
          <a class="to_index_btn" href="index.php">Myツール登録画面に戻る</a>
        </form>
      </section><!-- select_mytool -->
  </div><!-- .container -->
  </main>

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>
</body>

</html>