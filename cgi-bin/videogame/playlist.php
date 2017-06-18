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

$videogamesql = "SELECT * FROM orion.videogames m, orion.g_user_videogames g WHERE m.id = g.videogames_id and g.completed = 0 and g.user_id =".$user_id." order by m.title";
            $videogamequery = $db->query($videogamesql);

echo "<div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1><a href='videogame.php'>".$username." Videogame Playlist</a></h1>
					<a href='findvg.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Game</a></br>
					<ul class='list-group' id='list-items'>";
					foreach($videogamequery as $item){
            echo "<li class='list-group-item'><a data-toggle='tooltip' title='Add to ranking' href='played.php?id=".$item['g_id']."'>".$item['title']."</a></li>";
					}
echo"	</ul>
		</div>";

}
else
	  header("location: movie.php");

include('../footer.php');
echo "</div></body></html>";
?>
