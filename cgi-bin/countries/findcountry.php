<?php

if(!isset($_SESSION)) {
  session_start();
} ;
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

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

if ($_SESSION['usergroup'] == 'User' or $_SESSION['usergroup'] == 'Admin') {
    echo "
    <div class='col-md-3'></div>
    <div class='col-md-6'>
    <form class='form-signin' action='findcountry.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <div class='text-center'><label for='title'><h2>Country Name</h2></label></div>
      <input type='text' class='form-control' name='title_search' value='" . $search . "'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-search'></span> Search</button></form></br>";

    if (isset($search)) {
        $searchafter = urlencode($search);
        $api         = "https://restcountries.eu/rest/v1/name/" . $searchafter;
        $apiresponse = file_get_contents($api);
        $json        = json_decode($apiresponse);
        echo $json->{'status'};
        // TODO Alerts based on search results.
        if ($json->{'message'} == 'Not Found') {
            echo "<h2>No matches this search term.</h2>";
        } else {
            echo "<ul class='list-group'>";

            foreach ($json as $jsonitem) {
                echo "<li class='list-group-item'><a href='addcountry.php?title=" . $jsonitem->{'name'} . "&country_code=" . $jsonitem->{'alpha2Code'} . "'>" . $jsonitem->{'name'} . "</a></li>";
            }
            echo "</ul>
            </div>";
        }
    }
} else
    header("location: country.php");

include('../footer.php');
echo "</div></body></html>";
?>
