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
        <title id='pageTitle'>LeoNine Studios</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if ($_SESSION['usergroup'] == 'Admin'){
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
    $api = "http://www.omdbapi.com/?s=$searchafter&r=JSON";
    $apiresponse =  file_get_contents($api);
    $json = json_decode($apiresponse);

    echo "<ul class='list-group' id='list-items'>";

    					foreach($json->{'Search'} as $jsonitem){
								echo "<li class='list-group-item'><a href='addmovie.php?imdbid=".$jsonitem->{'imdbID'}."'>".$jsonitem->{'Title'}."</a></li>";
    					}
    echo "</ul>
    		</div>";
  }
}
else
	  header("location: movietable.php");

include('../footer.php');
echo "</div></body></html>";
?>
