<?php
require_once '../connectToDB.php';
session_start();
$user_id = $_SESSION['userid'];

$ids = $_GET['item'];
$ranking = 1;

if (isset($_GET['rank'])) {
  $ranking = $_GET['rank'];
}
$table = 'orion.g_user_';

if (isset($_GET['table'])) {
  $table .= $_GET['table'];
}

foreach($ids as $id) {
  $sql = "UPDATE $table SET rank = $ranking WHERE g_id = $id";
  $db->exec($sql);
  $ranking++;
}
?>
