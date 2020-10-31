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

$moviesql = "SELECT * FROM orion.movies m, orion.g_user_movies g WHERE m.id = g.movies_id and g.completed = 0 and g.user_id =".$user_id." order by m.title";
            $moviequery = $db->query($moviesql);

echo "<div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1><a href='movie.php'>".$username." Movie Watchlist</a></h1>
					<a href='findmovie.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Movie</a></br>
					<ul class='list-group'>";
					foreach($moviequery as $item){
            echo "<li class='list-group-item'><a href='http://www.imdb.com/title/".$item['imdb']."' target='_blank'><span data-toggle='tooltip' title='View IMDB page' class='glyphicon glyphicon-film'></span></a>    <a data-toggle='tooltip' title='Add to ranking' href='watched.php?id=".$item['g_id']."'>".$item['title']." (".date("Y", strtotime($item['release_date'])).")</a><a class='delete' id='".$item['g_id']."'><span class='pull-right glyphicon glyphicon-remove' data-toggle='tooltip' title='Remove Movie from Watchlist'></span></a></li>";
					}
echo"	</ul>
		</div>";

}
else
	  header("location: movie.php");

include('../footer.php');
echo "</div>
<script type='text/javascript'>
$(document).ready(function () {
  $('.delete').on('click', function () {
    $.ajax({
     type: 'POST',
     url: '../lib/deletefromlist.php?table=g_user_movies&id=' + $(this).attr('id')
    }).done(function( msg ) {
      location.reload();
    });
  });
});
</script>
</body></html>";
?>
