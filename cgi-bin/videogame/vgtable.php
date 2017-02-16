<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam Leonard</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$user_id = $_SESSION['userid'];

$sqlcomplete = "SELECT * FROM orion.videogames m, orion.g_user_videogames g WHERE m.id = g.videogames_id and g.user_id ='$user_id' order by g.rank DESC";

if (isset($_SESSION['userid']))
        {
                $querycomplete = $db->query($sqlcomplete);
          echo "<div class='container text-center'><h1><a href='videogame.php'>Video Games</a></h1>";
          echo "<table id='myTable'>";
          echo "<thead><tr><td>Title</td><td>IGDB</td><td>Release Date</td><td>System</td><td>IGDB Rating</td><td>Ranking</td></tr></thead>";

                  foreach($querycomplete as $item){
                          $id = $item['igdb'];
                          $api = "https://www.igdb.com/api/v1/games/$id?token=EEmW0D2LTmx-tJ2Nt492QzpmyZjEFos6G4Exi0OcJgc";
                          $apiresponse =  file_get_contents($api);
                          $json = json_decode($apiresponse, true);
                          echo "<tr><td><a href='videogamedetails.php?id=".($item['id']."'>".$json['game']['name']."</a></td><td><a href='https://www.igdb.com/games/".$json['game']['slug']."' target='_blank'>".$item['igdb']."</a></td><td>".$json['game']['release_dates'][0]['release_date']."</td><td>".$json['game']['release_dates'][0]['platform_name']."</td><td>".round($json['game']['rating'], 2)."/10</td><td>".$item['rank']."</td></tr>");
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
      'order': [[ 4, 'desc' ]]
    });
  });
</script>
</html>";
?>
