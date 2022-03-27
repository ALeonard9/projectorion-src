<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$user_id = $_GET['id'];

$user = 'Adam';
if (isset($user)) {
	$username = $user.'\'s';
}

$sql        = "SELECT * FROM orion.videogames c, orion.g_user_videogames g WHERE c.id = g.videogames_id and (g.rank >= $start_rank or g.rank = 0 ) and g.completed = 1 and g.user_id =" . $user_id . " order by rank";
$query      = $db->query($sql);
$sqlsum     = "SELECT count(*) as Count FROM orion.videogames c, orion.g_user_videogames g WHERE c.id = g.videogames_id and g.completed = 1 and g.user_id =" . $user_id;
$querysum   = $db->query($sqlsum);
$resultssum = $querysum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1>".$username." Video Games</h1>
					<h3>Games Finished:".$resultssum['Count']."</h3>
          </br>
		  <ul>";
        
		  foreach ($query as $item) {
			  $url = preg_replace("/^http:/i", "https:", $item['poster_url']);
			  echo "<li draggable=true class='list-group-item' id='item_" . ($item['g_id'] . "'><a href='videogamedetails.php?id=" . $item['videogames_id'] . "'><img src='" . $url . "' class='img-rounded img-responsive' style='width:30px;height:20px;float:left'><span class='badge'>" . $item['rank'] . "</span>   " . $item['title'] . "</a></li>");
		  }
		  echo "    </ul>
		  Game information was freely provided by <a href='https://www.igdb.com' target='_newtab'>IGDB.com.</a></div>
		</div>";

include('../footer.php');
echo "</div></body></html>";
?>
