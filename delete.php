<?php 
session_start();
require('dbconnect.php');

if (isset($_SESSION['id'])) {
  $id = $_REQUEST['id'];

  $tools = $db->prepare('SELECT * FROM tools WHERE id=?');
  $tools->execute(array($id));
  $tool = $tools->fetch();

  $del = $db->prepare('DELETE FROM tools WHERE id=?');
  $del->execute(array($id));
}

header('Location: index.php');
exit();
