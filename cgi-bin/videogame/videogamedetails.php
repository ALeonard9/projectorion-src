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
$user_id = $_SESSION['userid'];

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin') {
    
    if (isset($_GET['id'])) {
        $vg_id = $_GET['id'];
    } else {
      header("location: findvg.php");
    }
    $sql   = "SELECT v.title, v.igdb, v.poster_url, v.release_date, v.rating, v.slug, g.g_id, g.rank, g.completed, g.notes FROM videogames v, g_user_videogames g WHERE v.id = " . $vg_id . " AND v.id = g.videogames_id AND g.user_id = " . $user_id . ";";
    $query = $db->query($sql);
    $item = $query->fetch(PDO::FETCH_ASSOC);

    $metricssql =  "SELECT count(*) as completed_games  FROM orion.g_user_videogames where user_id = ".$user_id." AND completed = 1";
    $metricquery = $db->query($metricssql);
    $metrics = $metricquery->fetch(PDO::FETCH_ASSOC);
   

    $poster = "https:".$item['poster_url'];
    $poster_url = str_replace('t_thumb', 't_cover_big', $poster);
    
    echo "<div class='col-md-12'><a href='videogamedetails.php?id=".$vg_id."' class='fixed_middle_right' ><span class='glyphicon glyphicon-refresh'></span></a></div>
            <div class='col-md-6'>
              <a target='_blank' href='https://www.igdb.com/games/".$item['slug']."'><img src='".$poster_url."' class='img-rounded img-responsive center-block' style='margin-bottom:10px'></a>
              <div class='text-center'><h2>".$item['title']."</h2></div>
              <div class='text-center'><h2>Release Date: ".date('m-d-Y', strtotime($item['release_date']))."</h2></div>
              <div class='text-center'><h2>Rating: ".$item['rating']."/100</h2></div>
            </div>
            <div class='col-md-6'>
              <label>Your Ranking: ".$item['rank']."/".$metrics['completed_games']."</label>
              <form id='notes-form' name='notes-form' action='notes.php' method='POST'>
              <div class='form-group'>
                <label for='textbox'>Your Notes:</label>
                <textarea class='form-control' id='textbox' name='textbox' rows='3'>".$item['notes']."</textarea>
                <input id='g_id' name='g_id' type='hidden' value='".$item['g_id']."'>
                <input id='vg_id' name='vg_id' type='hidden' value='".$vg_id."'>

              </div>
              </form>
              <a class='btn btn-lg btn-inverse btn-block' onclick='document.getElementById(\"notes-form\").submit();'>Submit</a>
            </div>";
} else
    header("location: findvg.php");

include('../footer.php');
echo "</body></html>";
?>