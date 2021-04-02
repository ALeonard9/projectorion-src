<?php

session_start();
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
$user_id = $_SESSION['userid'];
$begin = date('Y-m-d', strtotime('-30 days'));

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){
    $log_array = array();
    $array_sort = array();
    // Build tv list
    $sql = "SELECT t.title as tv_title, e.season, e.season_number, e.title, g.g_first, g.g_id, t.id as tv_id FROM orion.tv t, orion.g_user_tv u, orion.g_user_tvepisodes g, orion.tvepisodes e WHERE u.tv_id = t.id AND g.tvepisode_id = e.id AND g.user_id = ".$user_id." AND u.user_id = ".$user_id." AND e.tv_id = t.id AND g.watched = 1 AND g.g_first >= '".$begin."' order by g.g_first DESC";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(255, 255, 204);'>TV: <a href='../tv/tvdetails.php?id=".$item['tv_id']."'>".$item['tv_title']."</a> ".$item['season'].".".$item['season_number'].": ".$item['title']."</li>";
        array_push($log_array, array($item['g_first'], $full_string));
        array_push($array_sort, $item['g_first']);
    }

    // Build movie list
    $sql = "SELECT m.id, m.title, g.g_first FROM orion.movies m, orion.g_user_movies g WHERE  m.id = g.movies_id AND g.user_id = ".$user_id." AND g.completed = 1 AND g.g_first >= '".$begin."' order by g.g_first DESC";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(204, 255, 255);'>MOVIE: <a href='../movies/moviedetails.php?id=".$item['id']."'>".$item['title']."</a></li>";
        array_push($log_array, array($item['g_first'], $full_string));
        array_push($array_sort, $item['g_first']);
    }

    // Build video game list
    $sql = "SELECT v.id, v.title, g.g_first FROM orion.videogames v, orion.g_user_videogames g WHERE  v.id = g.videogames_id AND g.user_id = ".$user_id." AND g.completed = 1 AND g.g_first >= '".$begin."' order by g.g_first DESC";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(204, 204, 255);'>VIDEO GAME: <a href='../videogame/videogamedetails.php?id=".$item['id']."'>".$item['title']."</a></li>";
        array_push($log_array, array($item['g_first'], $full_string));
        array_push($array_sort, $item['g_first']);
    }

    // Build book list
    $sql = "SELECT b.id, b.title, g.g_first FROM orion.books b, orion.g_user_books g WHERE  b.id = g.books_id AND g.user_id = ".$user_id." AND g.completed = 1 AND g.g_first >= '".$begin."' order by g.g_first DESC";
    $query = $db->query($sql);
    foreach($query as $item){
        $full_string = "<li class='list-group-item' style='background-color:rgb(102, 204, 255);'>BOOK: <a href='../books/bookdetails.php?id=".$item['id']."'>".$item['title']."</a></li>";
        array_push($log_array, array($item['g_first'], $full_string));
        array_push($array_sort, $item['g_first']);
    }

    array_multisort($array_sort, SORT_DESC, $log_array);
    $count = count($log_array);
    if ($count > 0) {
    echo "<div class='col-md-12'><h1 class='text-center'>Activity Log</h1>
            <div class='panel-group'>";
            $day = 0;
            foreach($log_array as $item){
                $item_day = date('m-d', strtotime($item[0]));
                if($day != $item_day && $day != 0){
                echo "</ul></div></div>";
                }
                if( $day != $item_day){
                $day = $item_day;
                echo "<div class='panel panel-default'>
                <div class='panel-heading'>
                    <h4 class='panel-title'>
                    ".date('l', strtotime($item[0]))." ".date('m-d', strtotime($item[0]))."<a data-toggle='collapse' href='#collapse".$item_day."'><span class='pull-right glyphicon glyphicon-minus'></span></a>
                    </h4>
                </div>
                <div id='collapse".$item_day."' class='panel-collapse collapse in'>
                    <ul class='list-group'>";
                }
 
                echo $item[1];
            }
            echo "</div></div></div></div>";
    } else {
    echo "<h1>No recent activity!</h1>";
    }

    echo "</div>";
}
else
	  header("location: ../users/signin.php");

include('../footer.php');
echo "</div>
</body></html>";
?>
