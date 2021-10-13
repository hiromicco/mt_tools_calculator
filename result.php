<?php
session_start();

$checked_select = $_POST['select'];
$checked_category = $_POST['category'];
$checked_tool_name = $_POST['tool_name'];
$checked_weight = $_POST['weight'];
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
  <header class="header">
    <div class="header__inner">
      <a class="header__title" href="index.php">
        <h1><img src="images/mountain-icon.svg" alt="">重さ計算ツール</h1>
      </a>
    </div><!-- header__inner -->
  </header>

  <main>
    <section class="result">
      <div class="result__inner">
        <p class="result__text">重さは合計</p>
        <div class="result__weight">
          <?php
          $sum = 0;
          foreach ($_POST['select'] as $select) {
            $sum += $select;
          }
          echo $sum;
          ?>
          <span>g</span>
        </div><!-- result__weight -->
      </div><!-- result__inner -->
      <h2 class="title_center mb_xs">今回持っていく道具</h2>

      <table class="result__table">
        <tr>
          <th>カテゴリー</th>
          <th>品名</th>
          <th>重さ</th>
        </tr>
        <?php foreach ($checked_select as $key => $value): ?>
          <tr>
            <td><?php print(htmlspecialchars($checked_category[$key], ENT_QUOTES)); ?></td>
            <td><?php print(htmlspecialchars($checked_tool_name[$key], ENT_QUOTES)); ?></td>
            <td><?php print(htmlspecialchars($checked_weight[$key], ENT_QUOTES)); ?>&nbsp;g</td>
          </tr>
        <?php endforeach; ?>
      </table>
      <a class="btn btn_gr btn_md mb_md" href="select.php?id=<?php print(htmlspecialchars($_SESSION['id'], ENT_QUOTES)); ?>">道具を選びなおす</a>
      <a class="btn btn_yl btn_lg" href="index.php">Myツール登録画面に戻る</a>
    </section><!-- result -->
  </main>

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>
</body>

</html>