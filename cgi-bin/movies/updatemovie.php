<?php
require '../composer/vendor/autoload.php';
include '../connectToDB.php';
include 'functions/functions.php';


if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if (isset($_GET['id'])) {
  updateMovie($_GET['id']);
} else {
  $sql = "SELECT imdb FROM orion.movies";
  $query = $db->query($sql);

  foreach($query as $item){
    updateMovie($item['imdb']);
  }

}
header("location: movie.php");

?>
