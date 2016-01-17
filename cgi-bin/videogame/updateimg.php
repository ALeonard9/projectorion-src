<?php

include '../connectToDB.php';
$api = 'http://www.omdbapi.com/?i=';
$sql = "SELECT id, imdb from orion.movies";
$update = "";
$query = $db->query($sql);

foreach($query as $item){
  $apiresponse =  file_get_contents($api.$item['imdb']);
  $json = json_decode($apiresponse);
  $poster =  $json->{'Poster'};
  if ($poster == 'N/A') {
  	$poster = 'https://upload.wikimedia.org/wikipedia/en/f/f9/No-image-available.jpg';
  }
  $update .= "UPDATE orion.movies SET `poster_url`='".$poster."' WHERE id = '".$item['id']."';";

}
echo $update;
// $db->query($update);
?>
