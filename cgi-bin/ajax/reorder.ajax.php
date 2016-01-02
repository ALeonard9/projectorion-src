<?php
require_once '../connectToDB.php';

$ids = $_GET['item'];
$ranking = 1;
$table = 'imdb.movie';

foreach($ids as $id) {
  $sql = "UPDATE $table SET movieRanking = $ranking WHERE movieID = $id";
  $db->exec($sql);
  $ranking++;
}
?>
