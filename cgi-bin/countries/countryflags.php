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

$api = 'http://www.geonames.org/flags/x/';
$user_id = $_SESSION['userid'];


  $sqlcomplete = "SELECT * FROM orion.countries c, orion.g_user_countries g WHERE c.id = g.countries_id and g.user_id =".$user_id." order by rank";
  $sqlgamesum = "SELECT count(*) as Count FROM orion.countries c, orion.g_user_countries g WHERE c.id = g.countries_id and g.completed = 1 and g.user_id =".$user_id;

  if (isset($_SESSION['userid']))
          {
                  $querycomplete = $db->query($sqlcomplete);
                          #$resultsopen = $queryopen->fetch(PDO::FETCH_ASSOC);
                  $querygamesum = $db->query($sqlgamesum);
                           $resultsgamesum = $querygamesum->fetch(PDO::FETCH_ASSOC);

          echo "<div class='container text-center'><h1><a href='country.php'>Countries</a></h1>";
          echo "<h3>Countries Visited:".$resultsgamesum['Count']."</h3>";
                  foreach($querycomplete as $item){
                          $apiresponse = $api.$item['country_code'].".gif";

                          echo "<div class='col-md-4'><a href='countrydetails.php?id=".$item['id']."'><span title='".$item['rank'].". ".$item['title']."'><img src='".$apiresponse."' class='img-rounded img-responsive center-block' style='width:300px;height:200px;margin-bottom:10px'></a></span></div>";
                  }
          echo "</div>";
          }
  else
          header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
