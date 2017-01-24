<?php

$datecomp = '2017-02-26';
$today = date();
$week =  date('Y-m-d', strtotime('+7 days'));

if ($datecomp >= $today && $datecomp <= $week){
  echo "In";
}
