<?php

include '../connectToDB.php';
$api = 'http://www.omdbapi.com/?i=';
$sql = "SELECT id, imdb, title from orion.movies";
$update = "";
$query = $db->query($sql);

foreach($query as $item){
  $apiresponse =  file_get_contents($api.$item['imdb']);
  $json = json_decode($apiresponse);
  $title =  $json->{'Title'};
  if ($title != $item['title']){
    $update .= "UPDATE orion.movies SET `title`='".$title."' WHERE id = '".$item['id']."';";
  }
}
echo $update;
// $db->query($update);
?>
