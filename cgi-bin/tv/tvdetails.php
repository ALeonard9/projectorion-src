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

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){

if (isset($_GET['id'])) {
  $show_id = $_GET['id'];
}
$allshowssql = "SELECT t.title, g.status, t.id FROM orion.g_user_tv g, orion.tv t WHERE g.tv_id = t.id AND g.user_id = ".$user_id." ORDER BY CASE g.status WHEN 'behind' THEN 1 WHEN 'Up to Date' THEN 2 WHEN 'Complete' THEN 3 END, title";
$allshows = $db->query($allshowssql);
$metricssql = "SELECT count(*) as subset, (SELECT COUNT(*) FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND tv_id = ".$show_id." AND user_id = ".$user_id." AND e.airdate <= '".date('Y-m-d')."') AS total FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND tv_id = ".$show_id." AND user_id = ".$user_id." AND watched = 1";
$metricquery = $db->query($metricssql);
         $metrics = $metricquery->fetch(PDO::FETCH_ASSOC);
$titlesql = "SELECT title as title FROM orion.tv where id = $show_id";
$querytitle = $db->query($titlesql);
         $series_title = $querytitle->fetch(PDO::FETCH_ASSOC);
$statussql = "SELECT status FROM orion.g_user_tv where user_id = $user_id AND tv_id = $show_id";
$querystatus = $db->query($statussql);
          $status = $querystatus->fetch(PDO::FETCH_ASSOC);
$freezesql = "SELECT freeze FROM orion.g_user_tv where user_id = $user_id AND tv_id = $show_id";
$freezestatus = $db->query($freezesql);
          $freeze = $freezestatus->fetch(PDO::FETCH_ASSOC);
$gidsql = "SELECT g_id FROM orion.g_user_tv where user_id = $user_id AND tv_id = $show_id";
$gidstatus = $db->query($gidsql);
          $gid = $gidstatus->fetch(PDO::FETCH_ASSOC);
$sql = "SELECT g.g_id, e.title, e.season, e.season_number, g.watched FROM orion.g_user_tvepisodes g, orion.tvepisodes e WHERE g.tvepisode_id = e.id AND e.tv_id = ".$show_id." AND user_id = ".$user_id." AND e.airdate <= '".date('Y-m-d')."' order by e.season ASC, e.season_number ASC";
$query = $db->query($sql);
$classw = '';
switch ($status['status']) {
    case 'Up to Date':
        $classw = 'uptodate';
        break;
    case 'Behind':
        $classw = 'behind';
        break;
    case 'Complete':
        $classw = 'complete';
        break;
}
$classf = '';
$classc = '';
$messagef = '';
switch ($freeze['freeze']) {
    case '0':
        $classf = 'unfrozen';
        $messagef = 'Freeze Tracking';
        $classc = 'btn-inverse';
        break;
    case '1':
        $classf = 'frozen';
        $messagef = 'Unfreeze Tracking';
        $classc = 'btn-primary';
        break;
}
//   <a href='tv.php'>".$series_title['title']."
echo "<div class='col-md-3'></div>
			<div class='col-md-6'><h1 class='text-center'>
      <select name='forma' style='border:0px;outline:0px;'onchange='location = this.value;'>";
      $showstatus = '';
      foreach($allshows as $item){
        $classd = '';
        switch ($item['status']) {
            case 'Up to Date':
                $classd = 'uptodate';
                break;
            case 'Behind':
                $classd = 'behind';
                break;
            case 'Complete':
                $classd = 'complete';
                break;
        }
        if($showstatus != $item['status'] && $showstatus != 0){
          echo "</optgroup>";
        }
        if($showstatus != $item['status']){
          $showstatus = $item['status'];
          echo "<optgroup class='".$classd."' label='".$showstatus."'>";
        }
        echo "<option value='tvdetails.php?id=".$item['id']."' ";
        if($item['id'] == $show_id){
          echo "selected";
        }
        echo ">".$item['title']."</option>";
      }

      echo "</select>
      </h1>
      <h3 class='text-center'><span id='done'>".$metrics['subset']."</span>/<span id='total'>".$metrics['total']."</span> : <span id='percent'></span>% <button class='pull-right ".$classw."' >".$status['status']."</button></h3>";
if ($metrics['total'] - $metrics['subset'] > 0 ) {
  echo "<a class='btn btn-lg btn-inverse btn-block fullseason' >Watched All</a>";
}
echo "<a href='updateseries.php?tv_id=$show_id' class='btn btn-lg btn-inverse btn-block' >Update Data</a>";
echo "<a href='deletetv.php?tv_id=$show_id' class='btn btn-lg btn-inverse btn-block' >Remove Data</a>";
echo "<button class='btn btn-lg $classc btn-block $classf' id='".$gid['g_id']."' >$messagef</button>";
echo "<a href='tv.php' class='btn btn-lg btn-inverse btn-block' >TV Home</a><br/>";
echo "<div class='panel-group'>";
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
  $('.watched,.unwatched').on('click', function () {
    $(this).toggleClass('watched').toggleClass( 'unwatched' );
    if ($(this).html() == 'Watched') {
      $(this).html('Not Watched');
      watched = 0;
      changeDone(-1);
    } else {
      $(this).html('Watched');
      watched = 1;
      changeDone(1);
    }
    $.ajax({
     type: 'POST',
     url: 'watchpivot.php?id=' + $(this).attr('id') + '&watched=' + watched
    }).done(function( msg ) {
    });
    updateMetrics();
  });
  var freeze = 0;
  $('.frozen,.unfrozen').on('click', function () {
    $(this).toggleClass('frozen').toggleClass( 'unfrozen' );
    $(this).toggleClass('btn-inverse').toggleClass( 'btn-primary' );
    if ($(this).html() == 'Freeze Tracking') {
      $(this).html('Unfreeze Tracking');
      freeze = 1;
    } else {
      $(this).html('Freeze Tracking');
      freeze = 0;
    }
    $.ajax({
     type: 'POST',
     url: 'freezepivot.php?id=' + $(this).attr('id') + '&freeze=' + freeze
    }).done(function( msg ) {
    });
  });
  $('.fullseason').on('click', function () {
    $.ajax({
     type: 'POST',
     url: 'watchall.php?id=$show_id&watched=1&user_id=$user_id'
    }).done(function( msg ) {
    });
    location.reload();
  });
  $('.panel-collapse').each( function( index, el ) {
    if($(el).children().children().children('.unwatched').length == 0) {
     $(el).removeClass('in');
    }
  });

  function updateMetrics() {
    var done = parseInt($('#done').text());
    var total = parseInt($('#total').text());
    var final = ((done/total)* 100).toFixed(2);
    $('#percent').html(final);
  }
  function changeDone(add) {
    var done = parseInt($('#done').text());
    var final = done + add;
    $('#done').html(final);
  }
  updateMetrics();
});
</script>
</body></html>";
?>
