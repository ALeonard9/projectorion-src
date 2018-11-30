<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

$search = $_GET['search'];

if (isset($_POST['title_search'])) {
  $search = $_POST['title_search'];
}

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam's Sandbox</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){
  echo "
    <div class='col-md-3'></div>
    <div class='col-md-6'>
    <form class='form-signin' action='findmovie.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <div class='text-center'><label for='title'><h2>Movie Title</h2></label></div>
      <input type='text' class='form-control' name='title_search' value='".$search."'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-search'></span> Search</button></form></br>";

  if (isset($search)){
    $searchafter = urlencode($search);
    if (substr( $search, 0, 2 ) === 'tt') {
      $api = "http://www.omdbapi.com/?i=$searchafter&r=JSON&type=movie&apikey=98df30f1";
      $apiresponse =  file_get_contents($api);
      $json = json_decode($apiresponse);
      echo "<ul class='list-group'>";
                  echo "<li class='list-group-item'><a href='http://www.imdb.com/title/".$json->{'imdbID'}."' target='_blank'><span data-toggle='tooltip' title='View IMDB page' class='glyphicon glyphicon-film'></span></a>    <a data-toggle='tooltip' title='Add to ranking' href='addmovie.php?title=".urlencode($json->{'Title'})."&imdbid=".$json->{'imdbID'}."&complete=1'>".$json->{'Title'}."</a><a href='addmovie.php?title=".urlencode($json->{'Title'})."&imdbid=".$json->{'imdbID'}."&complete=0'><span data-toggle='tooltip' title='Add to Watchlist' class='glyphicon glyphicon-plus' style='float:right'></span></a></li>";
      echo "</ul>
          </div>";
    } else {
      $api = "http://www.omdbapi.com/?s=$searchafter&r=JSON&type=movie&apikey=98df30f1";
      $apiresponse =  file_get_contents($api);
      $json = json_decode($apiresponse);

      echo "<ul class='list-group' id='list-items'>";

                foreach($json->{'Search'} as $jsonitem){
                  echo "<li class='list-group-item'><a href='http://www.imdb.com/title/".$jsonitem->{'imdbID'}."' target='_blank'><span data-toggle='tooltip' title='View IMDB page' class='glyphicon glyphicon-film'></span></a>    <a data-toggle='tooltip' title='Add to ranking' href='addmovie.php?title=".urlencode($jsonitem->{'Title'})."&imdbid=".$jsonitem->{'imdbID'}."&complete=1'>".$jsonitem->{'Title'}."</a><a href='addmovie.php?title=".urlencode($jsonitem->{'Title'})."&imdbid=".$jsonitem->{'imdbID'}."&complete=0'><span data-toggle='tooltip' title='Add to Watchlist' class='glyphicon glyphicon-plus' style='float:right'></span></a></li>";
                }
      echo "</ul>
          </div>";
    }
  }
}
else
	  header("location: movietable.php");

include('../footer.php');
echo "</div></body></html>";
?>
