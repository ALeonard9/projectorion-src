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
date_default_timezone_set('America/New_York');
$begin = date('Y-m-d', strtotime('-5 days'));
$end = date('Y-m-d', strtotime('+5 days'));


if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){

$sql = "SELECT t.title as tv_title, g.g_id, e.title, e.season, e.season_number, e.airdate FROM orion.tv t, orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND user_id = ".$user_id." AND e.tv_id = t.id AND g.watched = 0 AND e.airdate >= '".$begin."' AND e.airdate <= '".$end."' order by e.airdate";
$query = $db->query($sql);
echo "<div class='col-md-3'></div>
			<div class='col-md-6'><h1 class='text-center'><a href='tv.php'>What to watch</a></h1>
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
                 <a data-toggle='collapse' href='#collapse".$item['airdate']."'>".date('l', strtotime($item['airdate']))." ".date('m-d', strtotime($item['airdate']))."</a>
               </h4>
             </div>
             <div id='collapse".$item['airdate']."' class='panel-collapse collapse in'>
               <ul class='list-group'>";
          }
          $classw = 'unwatched';
          $displayw = 'Not Watched';
          echo "<li class='list-group-item'>".$item['tv_title']." ".$item['season'].".".$item['season_number'].": ".$item['title']."<button class='pull-right ".$classw."' type='button' id='".$item['g_id']."'>".$displayw."</button></li>";
        }
        echo "</div></div>";
}
else
	  header("location: findtv.php");

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
    } else {
      $(this).html('Watched');
      watched = 1;
    }
    $.ajax({
     type: 'POST',
     url: 'watchpivot.php?id=' + $(this).attr('id') + '&watched=' + watched
    }).done(function( msg ) {
    });
  });
  $('.panel-collapse').each( function( index, el ) {
    if($(el).children().children().children('.unwatched').length == 0) {
     $(el).removeClass('in');
    }
  });
});
</script>
</body></html>";
?>
