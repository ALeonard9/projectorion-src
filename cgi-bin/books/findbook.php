<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
$search = '';
if (isset($_GET['search'])) {
  $search = $_GET['search'];
}

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
    <form class='form-signin' action='findbook.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <div class='text-center'><label for='title'><h2>Book Title</h2></label></div>
      <input type='text' class='form-control' name='title_search' value='".$search."'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-search'></span> Search</button></form></br>";

  if (isset($search)){
    $google_api_key= getenv('GOOGLE_API_KEY');
    $searchafter = urlencode($search);
    $api = "https://www.googleapis.com/books/v1/volumes?q=$searchafter";
    $api .= "&key=$google_api_key"; // Add your API key parameter
    $apiresponse =  file_get_contents($api);
    $json = json_decode($apiresponse, true);
    echo "<ul class='list-group'>";
              foreach($json['items'] as $jsonitem){
                echo "<li class='list-group-item'><a href='https://books.google.com/books?id=".$jsonitem['id']."' target='_blank'><span data-toggle='tooltip' title='View GoogleBooks page' class='glyphicon glyphicon-book'></span></a>    <a data-toggle='tooltip' title='Add to ranking'  href='addbook.php?title=".urlencode($jsonitem['volumeInfo']['title'])."&isbn=".$jsonitem['volumeInfo']['industryIdentifiers'][0]['identifier']."&poster=".urlencode($jsonitem['volumeInfo']['imageLinks']['thumbnail'])."&id=".$jsonitem['id']."&complete=1'>".$jsonitem['volumeInfo']['title']." by ".$jsonitem['volumeInfo']['authors'][0]."</a><a data-toggle='tooltip' title='Add to Readlist'  href='addbook.php?title=".urlencode($jsonitem['volumeInfo']['title'])."&isbn=".$jsonitem['volumeInfo']['industryIdentifiers'][0]['identifier']."&poster=".urlencode($jsonitem['volumeInfo']['imageLinks']['thumbnail'])."&id=".$jsonitem['id']."&complete=0'><span class='glyphicon glyphicon-plus' style='float:right'></span></a></li>";
              }
    echo "</ul>
        </div>";

  }
}
else
	  header("location: book.php");

include('../footer.php');
echo "</div></body></html>";
?>
