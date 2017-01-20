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
$metricssql = "SELECT count(*) as subset, (SELECT COUNT(*) FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND tv_id = ".$show_id." AND user_id = ".$user_id.") AS total FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND tv_id = ".$show_id." AND user_id = ".$user_id." AND watched = 1";
$metricquery = $db->query($metricssql);
         $metrics = $metricquery->fetch(PDO::FETCH_ASSOC);
$titlesql = "SELECT title as title FROM orion.tv where id = $show_id";
$querytitle = $db->query($titlesql);
         $series_title = $querytitle->fetch(PDO::FETCH_ASSOC);
$sql = "SELECT g.g_id, e.title, e.season, e.season_number, g.watched FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND e.tv_id = ".$user_id." order by e.season ASC, e.season_number ASC";
$query = $db->query($sql);
echo "<div class='col-md-3'></div>
			<div class='col-md-6'><h1 class='text-center'>".$series_title['title']."</h1>
      <h3 class='text-center'>".$metrics['subset']."/".$metrics['total']." : ".number_format( $metrics['subset']/$metrics['total'] * 100, 2 )."%</h3>
      <div class='panel-group'>";
        $season = 0;
        foreach($query as $item){
          if($season != $item['season'] && $season != 0){
            echo "</ul></div></div>";
          }
          if($season != $item['season']){
            $season = $item['season'];
            echo "<div class='panel panel-default'>
            <div class='panel-heading'>
               <h4 class='panel-title'>
                 <a data-toggle='collapse' href='#collapse".$item['season']."'>Season ".$item['season']."</a>
               </h4>
             </div>
             <div id='collapse".$item['season']."' class='panel-collapse collapse in'>
               <ul class='list-group'>";
          }
          $classw = 'unwatched';
          $displayw = 'Not Watched';
          if($item['watched'] == 1) {
            $classw = 'watched';
            $displayw = 'Watched';
          }
          echo "<li class='list-group-item'>".$item['season_number'].". ".$item['title']."<button class='pull-right ".$classw."' type='button' id='".$item['g_id']."'>".$displayw."</button></li>";
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
  $(':button').on('click', function () {
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
});
</script>
</body></html>";
?>
