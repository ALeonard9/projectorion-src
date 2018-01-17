<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

$search = $_GET['search'];

if (isset($_POST['title_search'])) {
  $search = $_POST['title_search'];
}
require '../composer/vendor/autoload.php';
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
    <form class='form-signin' action='findvg.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <div class='text-center'><label for='title'><h2>Game Title</h2></label></div>
      <input type='text' class='form-control' name='title_search' value='".$search."'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-search'></span> Search</button></form></br>";

  if (isset($search)){
    $searchafter = urlencode($search);
    $response = Unirest\Request::get("https://api-2445582011268.apicast.io/games/?fields=slug%2Cname%2Ccover&limit=10&offset=0&search=$searchafter",
      array(
        "user-key" => "64f0da709467b347d34ef8ca69194b87",
        "Accept" => "application/json"
      )
    );
    $json = json_decode($response->raw_body, true);
    echo "<ul class='list-group' id='list-items'>";
      foreach($json as $jsonitem){
        echo "<li class='list-group-item'><a href='https://www.igdb.com/games/".$jsonitem['slug']."' target='_blank'><span data-toggle='tooltip' title='View IGDB page' class='glyphicon glyphicon-knight'></span></a>    <a data-toggle='tooltip' title='Add to Ranking' href='addvg.php?title=".urlencode($jsonitem['name'])."&id=".$jsonitem['id']."&poster=".$jsonitem['cover']['url']."&complete=1'>".$jsonitem['name']."</a><a href='addvg.php?title=".urlencode($jsonitem['name'])."&id=".$jsonitem['id']."&poster=".$jsonitem['cover']['url']."&complete=0'><span data-toggle='tooltip' title='Add to Playlist' class='glyphicon glyphicon-plus' style='float:right'></span></a></li>";
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
