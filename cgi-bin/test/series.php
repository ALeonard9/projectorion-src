<?php
$series = ['tt0944947', 'tt1520211'];
$epirray = array();
foreach($series as $show){
  $i = 0;
  $end = true;
  do {
      ++$i;
      $api = "http://www.omdbapi.com/?i=$show&season=$i";
      $apiresponse =  file_get_contents($api);
      $json = json_decode($apiresponse);
      // echo "Season ".$i, PHP_EOL;

      if($json->{'Response'} == 'False'  ){
        $end = false;
      }
      foreach($json->{'Episodes'} as $epi){
       // echo $epi->{'Title'}, PHP_EOL;
        $epirray[$show][$epi->{'imdbID'}] = array(
          array("title" => $epi->{'Title'}),
          array("date" => $epi->{'Released'}),
          array("season" => $i),
          array("episode" => $epi->{'Episode'}));

      }
  } while ($end);

}

$final = json_encode($epirray);
echo $final;
%>
