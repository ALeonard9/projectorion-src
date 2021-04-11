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
  updateVG($_GET['id']);
} else {
  $sql = "SELECT igdb FROM orion.videogames";
  $query = $db->query($sql);

  foreach($query as $item){
    updateVG($item['igdb']);
  }

}
header("location: videogame.php");

?>
