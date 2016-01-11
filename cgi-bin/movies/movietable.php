<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>LeoNine Studios</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$api = 'http://www.omdbapi.com/?i=';

if(isset($_GET['sortby']))
  $sortby = $_GET['sortby'];
else
  $sortby = 'rank';

if(isset($_GET['order']))
  $order = $_GET['order'];
else
  $order = 'ASC';

if($order == 'ASC')
  $op = 'DESC';
else
  $op = 'ASC';

  $sqlcomplete = "SELECT * FROM orion.movies order by $sortby $order LIMIT 10";
  $sqlgamesum = "SELECT count(*) as Count FROM orion.movies WHERE completed = 1";

  if (isset($_SESSION['username']))
          {
                  $querycomplete = $db->query($sqlcomplete);
                          #$resultsopen = $queryopen->fetch(PDO::FETCH_ASSOC);
                  $querygamesum = $db->query($sqlgamesum);
                           $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

          echo "<div class='container text-center'><h1><a href='movie.php'>Movies</a></h1>";
          echo "<h3>Movies Watched:".$resultsgamesum['Count']."</h3>";
          echo "<table class='table table-hover table-striped'>";
          echo "<tr><td onclick=\"window.location='movie.php?sortby=Title&order=".$op."'\">Title</td><td onclick=\"window.location='movie.php?sortby=movieIMDB&order=".$op."'\">IMDB</td><td>Release Date</td><td>Rating</td><td>Runtime</td><td>IMDB Rating</td><td onclick=\"window.location='movie.php?sortby=movieRanking&order=".$op."'\">Ranking</td></tr>";

                  foreach($querycomplete as $item){
                          $apiresponse =  file_get_contents($api.$item['imdb']);
                          $json = json_decode($apiresponse);
                          echo "<tr><td><a href='moviedetails.php?movieID=".($item['id']."'>".$json->{'Title'}."</a></td><td><a href='http://www.imdb.com/title/".$item['imdb']."' target='_blank'>".$item['imdb']."</a></td><td>".$json->{'Released'}."</td><td>".$json->{'Rated'}."</td><td>".$json->{'Runtime'}."</td><td>".$json->{'imdbRating'}."</td><td>".$item['rank']."</td></tr>");
                  }
          echo "</table></div>";
          }
  else
          header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
