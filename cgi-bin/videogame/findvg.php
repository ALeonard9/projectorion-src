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

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin'){
  echo "
    <div class='col-md-3'></div>
    <div class='col-md-6'>
    <form class='form-signin' action='findvg.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <div class='text-center'><label for='title'><h2>Game Title</h2></label></div>
      <input type='text' class='form-control' name='title_search' value='".$search."'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-search'></span> Search</button></form></br>";

  if (isset($search)){
    $searchafter = urlencode($search);
    $api = "https://www.igdb.com/api/v1/games/search?token=EEmW0D2LTmx-tJ2Nt492QzpmyZjEFos6G4Exi0OcJgc&q=$searchafter";
    $apiresponse =  file_get_contents($api);
    $json = json_decode($apiresponse);

    echo "<ul class='list-group' id='list-items'>";

    					foreach($json->{'games'} as $jsonitem){
								echo "<li class='list-group-item'><a href='https://www.igdb.com/games/".$jsonitem->{'slug'}."' target='_blank'><span class='glyphicon glyphicon-knight'></span></a>    <a href='addvg.php?title=".urlencode($jsonitem->{'name'})."&id=".$jsonitem->{'id'}."&poster=".$jsonitem->{'cover'}."'>".$jsonitem->{'name'}."</a></li>";
    					}
    echo "</ul>
    		</div>";
  }
}
else
	  header("location: vgtable.php");

include('../footer.php');
echo "</div></body></html>";
?>
