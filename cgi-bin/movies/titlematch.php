<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>LeoNine Admin</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if ($_SESSION['usergroup'] == 'Admin'){
  $moviesql = "SELECT imdb, title, id FROM orion.movies order by imdb";
  $moviequery = $db->query($moviesql);
  $x = 0;
  $api = 'http://www.omdbapi.com/?apikey=98df30f1&i=';
  echo "<table id='myTable'>";
  echo "<thead><tr><td>IMDB</td><td>Title</td><td>IMDB Title</td></tr></thead>";

          foreach($moviequery as $item){
                  $apiresponse =  file_get_contents($api.$item['imdb']);
                  $json = json_decode($apiresponse);
                  if($item['title'] != $json->{'Title'}){
                    echo "<tr><td>".$item['imdb']."</td><td>".$item['title']."</td><td>".$json->{'Title'}."</td></tr>";
                    $x++;

                    $stmt = $db->prepare("UPDATE `orion`.`movies` SET `title`= :title WHERE `id`= :id");
                    $stmt->bindParam(':id', $item['id']);
                    $stmt->bindParam(':title', $json->{'Title'});
                    $stmt->execute();

                  }
          }
  echo "</table>
  <h1>".$x."</h1>";
}


include('../footer.php');
echo "</div></body></html>";
?>
