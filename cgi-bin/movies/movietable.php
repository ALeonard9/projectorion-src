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

  $user_id = $_SESSION['userid'];

  $sqlcomplete = "SELECT * FROM orion.movies m, orion.g_user_movies g WHERE m.id = g.movies_id and g.user_id ='$user_id' order by g.rank DESC";

  if (isset($_SESSION['userid']))
          {
                  $querycomplete = $db->query($sqlcomplete);

          echo "<div class='container text-center'><h1><a href='movie.php'>Movies</a></h1>";
          echo "<table id='myTable'>";
          echo "<thead><tr><td>Title</td><td>IMDB</td><td>Release Date</td><td>Rating</td><td>Runtime</td><td>IMDB Rating</td><td>Ranking</td></tr></thead>";

                  foreach($querycomplete as $item){
                          $apiresponse =  file_get_contents($api.$item['imdb']);
                          $json = json_decode($apiresponse);
                          echo "<tr><td><a href='moviedetails.php?movieID=".($item['id']."'>".$json->{'Title'}."</a></td><td><a href='http://www.imdb.com/title/".$item['imdb']."' target='_blank'>".$item['imdb']."</a></td><td>".$json->{'Released'}."</td><td>".$json->{'Rated'}."</td><td>".$json->{'Runtime'}."</td><td>".$json->{'imdbRating'}."</td><td>".$item['rank']."</td></tr>");
                  }
          echo "</table></div>";
          }
  else
          header("location: ../users/signin.php");

echo "</div></body>
<link rel='stylesheet' type='text/css' href='//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'/>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'></script>
<script type='text/javascript'>
  $(document).ready(function(){
    $('#myTable').dataTable();
  });
</script>
</html>";
?>
