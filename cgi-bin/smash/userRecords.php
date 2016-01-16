<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if(isset($_GET['sortby']))
  $sortby = $_GET['sortby'];
else
  $sortby = 'win_percentage';

if(isset($_GET['order']))
  $order = $_GET['order'];
else
  $order = 'DESC';

if($order == 'ASC')
  $op = 'DESC';
else
  $op = 'ASC';


$sqlUserRecords = "SELECT * FROM smash.userRecord order by $sortby $order";

if (isset($_SESSION['userid']))
        {
                $queryopen = $db->query($sqlUserRecords);

        echo "<div class='container text-center'><h3>User Records</h3>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td onclick=\"window.location='userRecords.php?sortby=display_name&order=".$op."'\">Name</td><td onclick=\"window.location='userRecords.php?sortby=wins&order=".$op."'\">Wins</td><td onclick=\"window.location='userRecords.php?sortby=games&order=".$op."'\">Total Games</td><td onclick=\"window.location='userRecords.php?sortby=win_percentage&order=".$op."'\">Win Percentage</td></tr>";

                foreach($queryopen as $item){
                        echo "<tr><td>".($item['display_name']."</td><td>".$item['wins']."</td><td>".$item['games']."</td><td>".$item['win_percentage']."</td></tr>");
                }
        echo "</table><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='smash.php'><span class='glyphicon glyphicon-tower'></span> Smash Home</button>
        </div>";

        }
else
        header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
