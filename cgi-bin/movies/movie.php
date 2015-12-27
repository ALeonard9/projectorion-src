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
  $sortby = 'movieRanking';

if(isset($_GET['order']))
  $order = $_GET['order'];
else
  $order = 'ASC';

if($order == 'ASC')
  $op = 'DESC';
else
  $op = 'ASC';

  $sqlcomplete = "SELECT * FROM imdb.movie order by $sortby $order";
  $sqlgamesum = "SELECT count(*) as Count FROM imdb.movie WHERE movieSeen = 1";

  if (isset($_SESSION['username']))
          {
                  $querycomplete = $db->query($sqlcomplete);
                          #$resultsopen = $queryopen->fetch(PDO::FETCH_ASSOC);
                  $querygamesum = $db->query($sqlgamesum);
                           $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

          echo "<div class='container text-center'><h1>Movie List</h1>";
          echo "<br><h3>Movies Watched:".$resultsgamesum['Count']."</h3>";
          echo "<!DOCTYPE html>";
          echo "<html>";
          echo "<table class='table table-hover table-striped'>";
          echo "<tr><td onclick=\"window.location='movie.php?sortby=Title&order=".$op."'\">Title</td><td onclick=\"window.location='movie.php?sortby=movieIMDB&order=".$op."'\">IMDB</td><td>Release Date</td><td>Rating</td><td>Runtime</td><td>IMDB Rating</td><td onclick=\"window.location='movie.php?sortby=movieRanking&order=".$op."'\">Ranking</td></tr>";

                  foreach($querycomplete as $item){
                          $apiresponse =  file_get_contents($api.$item['movieIMDB']);
                          $json = json_decode($apiresponse);
                          echo "<tr><td><a href='moviedetails.php?movieID=".($item['movieID']."'>".$json->{'Title'}."</a></td><td><a href='http://www.imdb.com/title/".$item['movieIMDB']."' target='_blank'>".$item['movieIMDB']."</a></td><td>".$json->{'Released'}."</td><td>".$json->{'Rated'}."</td><td>".$json->{'Released'}."</td><td>".$json->{'Runtime'}."</td><td>".$json->{'imdbRating'}."</td><td>".$item['movieRanking']."</td></tr>");
                  }
          echo "</table></div>";
          }
  else
          header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
