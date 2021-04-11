<?php

if(!isset($_SESSION)) {
  session_start();
} ;
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
        $id = $_GET['id'];
    } else {
      header("location: findbook.php");
    }
    $sql = "SELECT v.title, v.googleid, v.poster_url, g.g_id, g.g_first, g.rank, g.completed, g.notes FROM books v, g_user_books g WHERE v.id = " . $id . " AND v.id = g.books_id AND g.user_id = " . $user_id . ";";
    $query = $db->query($sql);
    $item = $query->fetch(PDO::FETCH_ASSOC);

    $metricssql =  "SELECT count(*) as completed_books  FROM orion.g_user_books where user_id = ".$user_id." AND completed = 1";
    $metricquery = $db->query($metricssql);
    $metrics = $metricquery->fetch(PDO::FETCH_ASSOC);
       
    echo "<div class='col-md-12'><a href='bookdetails.php?id=".$id."' class='fixed_middle_right' ><span class='glyphicon glyphicon-refresh'></span></a></div>
            <div class='col-md-6'>
              <a target='_blank' href='https://books.google.com/books?id=".$item['googleid']."'><img src='".$item['poster_url']."' class='img-rounded img-responsive center-block' style='margin-bottom:10px'></a>
              <div class='text-center'><h2>".$item['title']."</h2></div>
            </div>
            <div class='col-md-6'>
              <label>Your Ranking: ".$item['rank']."/".$metrics['completed_books']."</label></br>
              <label>First Watched: </label><input type='datetime-local' id='".$item['g_id']."'
              name='g_first' value='".str_replace(' ', 'T', $item['g_first'])."'>
              <form id='notes-form' name='notes-form' action='notes.php' method='POST'>
              <div class='form-group'>
                <label for='textbox'>Your Notes:</label>
                <textarea class='form-control' id='textbox' name='textbox' rows='3'>".$item['notes']."</textarea>
                <input id='g_id' name='g_id' type='hidden' value='".$item['g_id']."'>
                <input id='id' name='id' type='hidden' value='".$id."'>

              </div>
              </form>
              <a class='btn btn-lg btn-inverse btn-block' onclick='document.getElementById(\"notes-form\").submit();'>Submit</a>
            </div>";
} else
    header("location: findbook.php");

include('../footer.php');
echo "
<script type='text/javascript'>
$(document).ready(function () {
  $(\"input[name='g_first']\").change(function () {
    var first = $(this).val();
    $.ajax({
     type: 'POST',
     url: 'first_pivot.php?g_id=' + $(this).attr('id') + '&first=' + first
    }).done(function( msg ) {
    });
  });
});
</script></body></html>";
?>