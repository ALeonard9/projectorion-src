<?php

session_start();
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
$user_id = $_SESSION['userid'];
$username = 'Your';
if (isset($_SESSION['username'])) {
	$username = $_SESSION['username'].'\'s';
}
if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){

$start_rank = 1;

if (isset($_GET['rank'])) {
  $start_rank = $_GET['rank'];
}

if (isset($_POST['rank'])) {
  $start_rank = $_POST['rank'];
}

$sql = "SELECT * FROM orion.videogames c, orion.g_user_videogames g WHERE c.id = g.videogames_id and (g.rank >= $start_rank or g.rank = 0 ) and g.completed = 1 and g.user_id =".$user_id." order by rank";
            $query = $db->query($sql);
						$sqlgamesum = "SELECT count(*) as Count FROM orion.videogames c, orion.g_user_videogames g WHERE c.id = g.videogames_id and g.completed = 1 and g.user_id =".$user_id;
						$querygamesum = $db->query($sqlgamesum);
										 $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'><a href='videogame.php?rank=".$start_rank."' class='fixed_middle_right' ><span class='glyphicon glyphicon-refresh'></span></a></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1><a href='vgtable.php'>".$username." Video Games</a></h1>
          <a href='playlist.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-eye-open'></span> Playlist</a>
					<a href='findvg.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Game</a>
					<h3>Games Finished:".$resultsgamesum['Count']."</h3>
          <form class='form-signin' action='videogame.php' form='thisForm' method='POST'>
          <div class='input-group'>
            <input type='hidden' id='table' value='videogames'>
            <input type='number' class='form-control' id='rank' name='rank' value='".$start_rank."'>
            <span class='input-group-btn'>
              <button class='btn btn-default' type='submit'>Go To...</button>
            </span>
          </div>
          </form></br>
					<ul class='list-group' id='list-items'>";

					foreach($query as $item){
            $url = preg_replace("/^http:/i", "https:", $item['poster_url']);
						echo "<li draggable=true class='list-group-item' id='item_".($item['g_id']."'><a href='videogamedetails.php?id=".$item['videogames_id']."'><img src='".$url."' class='img-rounded img-responsive' style='width:30px;height:20px;float:left'><span class='badge'>".$item['rank']."</span>   ".$item['title']."</a></li>");
					}
echo"	</ul>
		Game information was freely provided by <a href='https://www.igdb.com' target='_newtab'>IGDB.com.</a></div>";

}
else
	  header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
