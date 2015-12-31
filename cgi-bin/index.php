<?php

session_start();
ob_start();

include 'connectToDB.php';

$moviesql = "SELECT * FROM imdb.movie order by movieRanking ASC LIMIT 5";
$vgsql = "SELECT * FROM videogame.game order by RATING DESC LIMIT 5";

echo "<!DOCTYPE html>
<html lang='en'>
<head>
	<meta charset='utf-8'>
	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name='description' content='aleonard.us'>
	<meta name='author' content='LeonineStudios@outlook.com'>

	<title>LeoNine Studios</title>

	<!-- Bootstrap core CSS -->
	<link href='./css/bootstrap.min.css' rel='stylesheet'>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href='./css/ie10-viewport-bug-workaround.css' rel='stylesheet'>

	<!-- Custom styles for this template -->
	<link href='./css/leo.css' rel='stylesheet'>

	<!-- Icons for mobile -->
	<link rel='apple-touch-icon' sizes='57x57' href='./apple-icon-57x57.png'>
	<link rel='apple-touch-icon' sizes='60x60' href='./apple-icon-60x60.png'>
	<link rel='apple-touch-icon' sizes='72x72' href='./apple-icon-72x72.png'>
	<link rel='apple-touch-icon' sizes='76x76' href='./apple-icon-76x76.png'>
	<link rel='apple-touch-icon' sizes='114x114' href='./apple-icon-114x114.png'>
	<link rel='apple-touch-icon' sizes='120x120' href='./apple-icon-120x120.png'>
	<link rel='apple-touch-icon' sizes='144x144' href='./apple-icon-144x144.png'>
	<link rel='apple-touch-icon' sizes='152x152' href='./apple-icon-152x152.png'>
	<link rel='apple-touch-icon' sizes='180x180' href='./apple-icon-180x180.png'>
	<link rel='icon' type='image/png' sizes='192x192'  href='./android-icon-192x192.png'>
	<link rel='icon' type='image/png' sizes='32x32' href='./favicon-32x32.png'>
	<link rel='icon' type='image/png' sizes='96x96' href='./favicon-96x96.png'>
	<link rel='icon' type='image/png' sizes='16x16' href='./favicon-16x16.png'>
	<meta name='apple-mobile-web-app-title' content='Leonine'>
	<link rel='manifest' href='./manifest.json'>
	<meta name='msapplication-TileColor' content='#ffffff'>
	<meta name='msapplication-TileImage' content='./ms-icon-144x144.png'>

</head>
<body>
		<div class='container'>

			<!-- Static navbar -->
			<nav class='navbar navbar-default'>
				<div class='container-fluid'>
					<div class='navbar-header'>
						<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
							<span class='sr-only'>Toggle navigation</span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
						</button>
						<a class='navbar-brand' href='index.php'>LeoNineStudios</a>
					</div>
					<div id='navbar' class='navbar-collapse collapse'>
						<ul class='nav navbar-nav'>
							<li><a href='index.php'>Dashboard</a></li>
							<li class='dropdown'>
	              <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Apps <span class='caret'></span></a>
	              <ul class='dropdown-menu'>
	                <li><a href='bet/betting.php'>Betting</a></li>
									<li><a href='bet/rules.php'>Rulebook</a></li>
	              	<li><a href='smash/smash.php'>Smash Up</a></li>
								</ul>
	            </li>
							<li class='dropdown'>
								<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Trackers <span class='caret'></span></a>
								<ul class='dropdown-menu'>
									<li><a href='movies/movie.php'>Movies</a></li>
									<li><a href='#'>Travel</a></li>
									<li><a href='#'>TV</a></li>
									<li><a href='videogame/videogame.php'>Video Games</a></li>
								</ul>
							</li>
							<li class='dropdown'>
								<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>About <span class='caret'></span></a>
								<ul class='dropdown-menu'>
									<li><a href='http://resume.aleonard.us'>Resume</a></li>
								</ul>
							</li>
						</ul>
						<ul class='nav navbar-nav navbar-right'>";
						if (isset($_SESSION['username']))
						{
							echo "<li class='dropdown'>
								<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Welcome " . $_SESSION['username'] . " <span class='caret'></span></a>
								<ul class='dropdown-menu'>
									<li><a href='./users/profile.php'>My Profile</a></li>
									<li><a href='./users/logout.php''>Log Out</a></li>
								</ul>
							</li>";
						}
						else
						{
						echo "<li><a href='./users/signin.php'>Sign In</a></li>";
						}

						$moviequery = $db->query($moviesql);
						$api = 'http://www.omdbapi.com/?i=';
						$vgquery = $db->query($vgsql);

echo "</ul>
					</div><!--/.nav-collapse -->
				</div><!--/.container-fluid -->
			</nav>
			<div class='col-md-6 text-center'>
					<h1><a href='movies/movie.php'>Movies</a></h1>
					<table class='table table-hover table-striped'>
					<tr><td>Title</td><td>IMDB</td><td>Ranking</td></tr>";

					foreach($moviequery as $item){
									$apiresponse =  file_get_contents($api.$item['movieIMDB']);
									$json = json_decode($apiresponse);
									echo "<tr><td><a href='movies/moviedetails.php?movieID=".($item['movieID']."'>".$json->{'Title'}."</a></td><td><a href='http://www.imdb.com/title/".$item['movieIMDB']."' target='_blank'>".$item['movieIMDB']."</a></td><td>".$item['movieRanking']."</td></tr>");
					}
echo"	</table>
			</div>
			<div class='col-md-6 text-center'>
					<h1><a href='videogame/videogame.php'>Video Games</a></h1>
					<table class='table table-hover table-striped'>
					<tr><td>Title</td><td>System</td><td>Rating</td></tr>";
					foreach($vgquery as $item){
							echo "<tr><td><a href='betdetails.php?betID=".($item['GameID']."'>".$item['Title']."</a></td><td>".$item['System']."</td><td>".$item['Rating']."</td></tr>");
					}
echo"</table>
			</div>
	</div>


	<!--================================================== -->
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>
	<script>window.jQuery || document.write(\"<script src='./js/vendor/jquery.min.js'><\/script>\")</script>
	<script src='./js/bootstrap.min.js'></script>
	<script src='./js/ie10-viewport-bug-workaround.js'></script>
</body>
</html>";

?>
