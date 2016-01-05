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

if ($_SESSION['usergroup'] == 'Admin'){

$start_rank = 1;

if (isset($_GET['rank'])) {
  $start_rank = $_GET['rank'];
}

if (isset($_POST['rank'])) {
  $start_rank = $_POST['rank'];
}

$moviesql = "SELECT * FROM imdb.movie WHERE movieRanking >= $start_rank or movieRanking = 0 order by movieRanking";
            $moviequery = $db->query($moviesql);
						$sqlgamesum = "SELECT count(*) as Count FROM imdb.movie WHERE movieSeen = 1";
						$querygamesum = $db->query($sqlgamesum);
										 $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

echo "<div class='col-md-12'><a href='movie.php?rank=".$start_rank."' class='fixed_middle_right' ><span class='glyphicon glyphicon-refresh'></span></a></div>
      <div class='col-md-3'></div>
			<div class='col-md-6'>
					<div class='text-center'><h1><a href='movietable.php'>Movies</a></h1>
					<a href='findmovie.php' class='btn btn-lg btn-inverse btn-block' ><span class='glyphicon glyphicon-plus'></span> Add a Movie</a>
					<h3>Movies Watched:".$resultsgamesum['Count']."</h3>
          <form class='form-signin' action='movie.php' form='thisForm' method='POST'>
          <div class='input-group'>
            <input type='number' class='form-control' id='rank' name='rank' value='".$start_rank."'>
            <span class='input-group-btn'>
              <button class='btn btn-default' type='submit'>Go To...</button>
            </span>
          </div>
          </form></br>
					<ul class='list-group' id='list-items'>";

					foreach($moviequery as $item){
									echo "<li draggable=true class='list-group-item' id='item_".($item['movieID']."'><a href='movies/moviedetails.php?movieID=".$item['movieID']."'><span class='badge'>".$item['movieRanking']."</span>   ".$item['movieTitle']."</a></li>");
					}
echo"	</ul>
		</div>";

}
else
	  header("location: movietable.php");

include('../footer.php');
echo "</div></body></html>";
?>
