<?php

session_start();
ob_start();
date_default_timezone_set('Etc/UTC');
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$omdb_api_key = getenv('OMDB_API_KEY');
$api = 'http://www.omdbapi.com/?apikey=' .$omdb_api_key. '&i=';

  $user_id = $_SESSION['userid'];

  $sqlcomplete = "SELECT * FROM orion.movies m, orion.g_user_movies g WHERE m.id = g.movies_id and g.completed = 1 and g.user_id ='$user_id' order by g.rank DESC";

  if (isset($_SESSION['userid']))
          {
          $querycomplete = $db->query($sqlcomplete);

          echo "<div class='container text-center'><h1><a href='movie.php'>Movies</a></h1>";
          echo "<table id='myTable'>";
          echo "<thead><tr><td>Title</td><td>IMDB</td><td>Release Date</td><td>Rating</td><td>Runtime (mins)</td><td>IMDB Rating</td><td>Ranking</td></tr></thead>";

                  foreach($querycomplete as $item){
                        echo "<tr><td><a href='moviedetails.php?movieID=".($item['id']."'>".$item['title']."</a></td><td><a href='http://www.imdb.com/title/".$item['imdb']."' target='_blank'>".$item['imdb']."</a></td><td>".date('Y-m-d',strtotime($item['release_date']))."</td><td>".$item['rated']."</td><td>".$item['runtime']."</td><td>".$item['rating_imdb']."</td><td>".$item['rank']."</td></tr>");
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
    $('#myTable').dataTable( {
      'order': [[ 5, 'desc' ]]
    });
  });
</script>
</html>";
?>
