<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
date_default_timezone_set('Etc/UTC');

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');
if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
}

$mode = 'random';
if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

if (isset($_SESSION['usergroup'])) {
if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){
    $unfinished_array = array();
    // Build tv list
    $sql = "SELECT t.title as tv_title, e.season, e.season_number, e.title, g.g_id, t.id as tv_id FROM orion.tv t, orion.g_user_tv u, orion.g_user_tvepisodes g, orion.tvepisodes e WHERE u.tv_id = t.id AND g.tvepisode_id = e.id AND g.user_id = ".$user_id." AND u.user_id = g.user_id AND e.tv_id = t.id AND g.watched = 0 ORDER BY tv_id, season, season_number";
    $query = $db->query($sql);
    $curr_tv_id = 0;
    foreach($query as $item){
        if ($item['tv_id'] != $curr_tv_id) {
            $full_string = "<li class='list-group-item' style='background-color:rgb(255, 255, 204);'>TV: <a href='../tv/tvdetails.php?id=".$item['tv_id']."'>".$item['tv_title']."</a> ".$item['season'].".".$item['season_number'].": ".$item['title']."</li>";
            array_push($unfinished_array, $full_string);
        }
        $curr_tv_id = $item['tv_id'];

    }

    // Build movie list
    $sql = "SELECT m.id, m.title, g.g_first FROM orion.movies m, orion.g_user_movies g WHERE  m.id = g.movies_id AND g.user_id = ".$user_id." AND g.completed = 0";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(204, 255, 255);'>MOVIE: <a href='../movies/moviedetails.php?id=".$item['id']."'>".$item['title']."</a></li>";
        array_push($unfinished_array, $full_string);
    }

    // Build video game list
    $sql = "SELECT v.id, v.title, g.g_first FROM orion.videogames v, orion.g_user_videogames g WHERE  v.id = g.videogames_id AND g.user_id = ".$user_id." AND g.completed = 0";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(204, 204, 255);'>VIDEO GAME: <a href='../videogame/videogamedetails.php?id=".$item['id']."'>".$item['title']."</a></li>";
        array_push($unfinished_array, $full_string);
    }

    // Build book list
    $sql = "SELECT b.id, b.title, g.g_first FROM orion.books b, orion.g_user_books g WHERE  b.id = g.books_id AND g.user_id = ".$user_id." AND g.completed = 0";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(102, 204, 255);'>BOOK: <a href='../books/bookdetails.php?id=".$item['id']."'>".$item['title']."</a></li>";
        array_push($unfinished_array, $full_string);
    }
    $count = count($unfinished_array);
    if ($count > 0) {
    echo "<div class='col-md-12'><h1 class='text-center'>What to do?</h1>
            <div class='panel-group'>";
            if ($mode == 'random') {
                shuffle($unfinished_array);
                echo $unfinished_array[0];
            } elseif ($mode == 'full') {
                foreach($unfinished_array as $item){
                    echo $item;
                }
            }

            echo "</div></div></div></div>";
    } else {
    echo "<h1>Nothing to do! Go outside!</h1>";
    }
    echo "
    <div class='col-md-6'>
    <a href='bored.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-refresh'></span> Roll again?</a>
    </div>
    <div class='col-md-6'>
    <a href='bored.php?mode=full' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-th-list'></span> See Full List</a>
    </div>";

    echo "</div>";
}
else
	  header("location: ../users/signin.php");
}
    else
          header("location: ../users/signin.php");

include('../footer.php');
echo "</div>
</body></html>";
?>
