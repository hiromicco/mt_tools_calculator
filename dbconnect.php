<?php 
$dsn = 'mysql:dbname=vanblog_mttools;host=mysql5018.xserver.jp;charset=utf8';
$user = 'vanblog_hymhouse';
$password = 'hymhouse0694';
try {
  $db = new PDO($dsn, $user, $password);
} catch(PDOException $e) {
  print('DB接続エラー：' . $e->getMessage());
}