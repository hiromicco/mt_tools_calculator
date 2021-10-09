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
  <link rel="stylesheet" href="css/result.css">
  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/c09da6029c.js" crossorigin="anonymous"></script>
  <!-- Font -->
</head>

<body>
  <header>
    <div class="container">
      <a class="site_title" href="index.php">
        <h1><img src="images/mountain-icon.svg" alt="">重さ計算ツール</h1>
      </a>
    </div><!-- container -->
  </header>

  <main>
    <section class="select_mytool tool_list">
      <div class="result">
        <p>重さは合計</p>
        <div class="total_weight">
          <?php
          $sum = 0;
          foreach ($_POST['select'] as $select) {
            $sum += $select;
          }
          echo $sum;
          ?>
          <span>g</span>
        </div><!-- total_weight -->
      </div><!-- result -->
      <h2>今回持っていく道具</h2>

      <table>
        <tr>
          <th>カテゴリー</th>
          <th>　　　品名　　　</th>
          <th>重さ</th>
        </tr>
        <?php foreach ($checked_select as $key => $value): ?>
          <tr>
            <td><?php print(htmlspecialchars($checked_category[$key], ENT_QUOTES)); ?></td>
            <td><?php print(htmlspecialchars($checked_tool_name[$key], ENT_QUOTES)); ?></td>
            <td><?php print(htmlspecialchars($checked_weight[$key], ENT_QUOTES)); ?>g</td>
          </tr>
        <?php endforeach; ?>
      </table>
      <a class="calculate_btn" href="select.php?id=<?php print(htmlspecialchars($_SESSION['id'], ENT_QUOTES)); ?>">道具を選びなおす</a>
      <a class="to_index_btn" href="index.php">Myツール登録画面に戻る</a>
    </section><!-- select_mytool -->
  </main>

  <footer>
    <p>Copyright 2021 重さ計算ツール</p>
  </footer>
</body>

</html>