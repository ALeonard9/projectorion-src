<?php

session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam Leonard</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$sql = "SELECT * FROM bet.rules";

if ($_SESSION['usergroup']=='Admin')
  {
    $query = $db->query($sql);
    echo "<div class='container text-center'><h1>Rules</h1>";

    foreach($query as $item){
          echo "<div class='row'><div class='col-md-12'><h3>".$item['ruleDescription']."</h3></div></div>";
          echo "<div class='row'><div class='col-md-6'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='newbetupdate.php?ruleid=".$item['ruleID']."&amount=".$item['soumAmount']."&winner=Adam'>Soumya ($".$item['soumAmount'].")</button></div>";
          echo "<div class='col-md-6'><button type='button' class='btn btn-inverse btn-lg btn-block' onclick=location.href='newbetupdate.php?ruleid=".$item['ruleID']."&amount=".$item['adamAmount']."&winner=Soumya'>Adam ($".$item['adamAmount'].")</button></div></div>";

    }
  }
else
  {
  header("location: ../users/signin.php");
  }
include('../footer.php');
echo "</table></div></div></body></html>";
?>
