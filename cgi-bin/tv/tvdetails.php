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
$user_id = $_SESSION['userid'];

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){

  if (isset($_GET['id'])) {
    $show_id = $_GET['id'];
  }
$titlesql = "SELECT title as title FROM orion.tv where id = $show_id";
$querytitle = $db->query($titlesql);
         $series_title = $querytitle->fetch(PDO::FETCH_ASSOC);
$sql = "SELECT e.title, e.season, e.season_number, g.watched FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND e.tv_id = ".$user_id." order by e.season ASC, e.season_number ASC";
$query = $db->query($sql);
echo "<div class='col-md-3'></div>
			<div class='col-md-6 text-center'><h1>".$series_title['title']."</h1>
      </div>";
}
else
	  header("location: findtv.php");

include('../footer.php');
echo "</div></body></html>";
?>
