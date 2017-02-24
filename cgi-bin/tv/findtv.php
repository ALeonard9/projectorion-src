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
    <form class='form-signin' action='findtv.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <div class='text-center'><label for='title'><h2>Tv Series</h2></label></div>
      <input type='text' class='form-control' name='title_search' value='".$search."'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-search'></span> Search</button></form></br>";

  if (isset($search)){
    $searchafter = urlencode($search);
    $response = Unirest\Request::get("http://api.tvmaze.com/search/shows?q=$searchafter",
      array(
        "Accept" => "application/json"
      )
    );

    $json = json_decode($response->raw_body, true);
    echo "<ul class='list-group' id='list-items'>";

    foreach($json as $jsonitem){
        echo "<li class='list-group-item'><a href='http://www.imdb.com/title/".$jsonitem['show']['externals']['imdb']."' target='_blank'><span class='glyphicon glyphicon-blackboard'></span></a>    <a href='addtv.php?status=".urlencode($jsonitem['show']['status'])."&title=".urlencode($jsonitem['show']['name'])."&id=".$jsonitem['show']['externals']['imdb']."&tvmaze=".$jsonitem['show']['id']."&poster=".urlencode(current($jsonitem['show']['image']))."'>".$jsonitem['show']['name']."</a></li>";
    }
    echo "</ul>
                </div>";
  }
}
else
          header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
