<?php 
$dsn = 'mysql:dbname=mt_tools_calculator;host=localhost;charset=utf8';
$user = 'root';
$password = 'root';
try {
  $db = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
  print('DB接続エラー：' . $e->getMessage());
}