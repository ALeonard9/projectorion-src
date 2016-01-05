<?php
require_once '../connectToDB.php';

$ids = $_GET['item'];
$ranking = 1;

if (isset($_GET['rank'])) {
  $ranking = $_GET['rank'];
}
$table = 'imdb.movie';

foreach($ids as $id) {
  $sql = "UPDATE $table SET movieRanking = $ranking WHERE movieID = $id";
  $db->exec($sql);
  $ranking++;
}
?>
