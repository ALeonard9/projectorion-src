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
$begin = date('Y-m-d', strtotime('-5 days'));
$end = date('Y-m-d', strtotime('+5 days'));
$today = date('Y-m-d');



if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){
$freezesql = "SELECT g.g_id, t.title, t.id FROM g_user_tv g, tv t WHERE t.id = g.tv_id AND g.freeze = 1 AND g.user_id = ".$user_id." ORDER BY t.title";
$freezequery = $db->query($freezesql);
$freezecount = $freezequery->rowCount();
$sql = "SELECT t.title as tv_title, g.g_id, e.title, e.season, e.season_number, e.airdate, t.id FROM orion.tv t, orion.g_user_tv u, orion.g_user_tvepisodes g, orion.tvepisodes e WHERE u.tv_id = t.id AND u.freeze = 0 AND g.tvepisode_id = e.id AND g.user_id = ".$user_id." AND u.user_id =".$user_id." AND e.tv_id = t.id AND g.watched = 0 AND e.airdate >= '".$begin."' AND e.airdate <= '".$end."' order by e.airdate, tv_title, season_number";
$query = $db->query($sql);
$unwatchedsql = "SELECT t.title as tv_title, g.g_id, e.title, e.season, e.season_number, e.airdate, t.id FROM orion.tv t, orion.g_user_tv u , orion.g_user_tvepisodes g, orion.tvepisodes e WHERE u.tv_id = t.id AND u.freeze = 0 AND g.tvepisode_id = e.id AND g.user_id = ".$user_id." AND u.user_id =".$user_id." AND e.tv_id = t.id AND g.watched = 0 AND e.airdate <= '".$today."' order by tv_title ASC, season ASC, season_number ASC";
$unwatchedquery = $db->query($unwatchedsql);
$count = $unwatchedquery->rowCount();
if ($count > 0) {
  echo "<div class='col-md-6'><h1 class='text-center'><a href='tv.php'>What to watch</a></h1>
        <div class='panel-group'>";
          $day = 0;
          foreach($query as $item){
            if($day != $item['airdate'] && $day != 0){
              echo "</ul></div></div>";
            }
            if( $day != $item['airdate']){
              $day = $item['airdate'];
              echo "<div class='panel panel-default'>
              <div class='panel-heading'>
                 <h4 class='panel-title'>
                   ".date('l', strtotime($item['airdate']))." ".date('m-d', strtotime($item['airdate']))."<a data-toggle='collapse' href='#collapse".$item['airdate']."'><span class='pull-right glyphicon glyphicon-minus'></span></a>
                 </h4>
               </div>
               <div id='collapse".$item['airdate']."' class='panel-collapse collapse in'>
                 <ul class='list-group'>";
            }
            $classw = 'unwatched';
            $displayw = 'Not Watched';
            if (strlen($item['title']) > 65) {
              $title = substr($item['title'], 0, 65)."...";
            } else {
              $title = $item['title'];
            }
            $full_string = "<a href='tvdetails.php?id=".$item['id']."'>".$item['tv_title']."</a> ".$item['season'].".".$item['season_number'].": ".$title;

            echo "<li class='list-group-item'>".$full_string."<button class='pull-right ".$classw."' type='button' id='".$item['g_id']."'>".$displayw."</button></li>";
          }
          echo "</div></div></div></div>
          <div class='col-md-6'><h1 class='text-center'>All unwatched: <span id='remain'>".$count."</span></h1>
          <div class='panel-group'>";
            $show = 'notset';
            foreach($unwatchedquery as $item){
              if($show != $item['tv_title'] && $show != 'notset'){
                echo "</ul></div></div>";
              }
              if( $show != $item['tv_title']){
                $show = $item['tv_title'];
                echo "<div class='panel panel-default'>
                <div class='panel-heading'>
                   <h4 class='panel-title'>
                     <a href='tvdetails.php?id=".$item['id']."'>".$item['tv_title']."</a><a data-toggle='collapse' href='#collapse".$item['g_id']."'><span class='pull-right glyphicon glyphicon-plus'></span></a>
                   </h4>
                 </div>
                 <div id='collapse".$item['g_id']."' class='panel-collapse collapse'>
                   <ul class='list-group'>";
              }
              $classw = 'unwatched';
              $displayw = 'Not Watched';
              $full_string = $item['season'].".".$item['season_number'].": ".$item['title'];
	// This function breaks It's always sunny		    
              if (strlen($full_string) > 65) {
                $full_string = substr($full_string, 0, 65)."...";
              }
              echo "<li class='list-group-item'>".$full_string."<button class='pull-right ".$classw."' type='button' id='".$item['g_id']."'>".$displayw."</button></li>";
            }
            echo "</ul></div></div>";

} else {
  echo "<h1>You are all caught up!</h1>";
}
if ($freezecount > 0){
  echo "</br><h1 class='text-center'>Frozen Shows </h1><ul class='list-group'>";
  foreach($freezequery as $item){
    echo "<li class='list-group-item'><a href='tvdetails.php?id=".$item['id']."'>".$item['title']."</a><a data-toggle='tooltip' title='Unfreeze Show' class='frozen' id='".$item['g_id']."'><span class='pull-right glyphicon glyphicon-certificate'></span></a></li>";
  }
  echo "</ul>";

} else {
  echo "";
}

    echo "</div>";
}
else
	  header("location: ../users/signin.php");

include('../footer.php');
echo "</div>
<script type='text/javascript'>
$(document).ready(function () {
  var watched = 0;
  $('.watched,.unwatched').on('click', function () {
    $(this).toggleClass('watched').toggleClass( 'unwatched' );
    if ($(this).html() == 'Watched') {
      $(this).html('Not Watched');
      watched = 0;
      changeDone(1);
    } else {
      $(this).html('Watched');
      watched = 1;
      changeDone(-1);
    }
    $.ajax({
     type: 'POST',
     url: 'watchpivot.php?id=' + $(this).attr('id') + '&watched=' + watched
    }).done(function( msg ) {
    });
  });
  $('.frozen').on('click', function () {
    $.ajax({
     type: 'POST',
     url: 'freezepivot.php?id=' + $(this).attr('id') + '&freeze=0'
    }).done(function( msg ) {
    });
    location.reload();
  });
  $('.glyphicon').on('click', function () {
    $(this).toggleClass('glyphicon-plus').toggleClass( 'glyphicon-minus' );
  });
  $('.panel-collapse').each( function( index, el ) {
    if($(el).children().children().children('.unwatched').length == 0) {
     $(el).removeClass('in');
    }
  });

  function changeDone(add) {
    var done = parseInt($('#remain').text());
    var final = done + add;
    $('#remain').html(final);
  }
});
</script>
</body></html>";
?>
