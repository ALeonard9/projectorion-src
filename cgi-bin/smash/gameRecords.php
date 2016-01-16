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
  $sortby = 'game_id';

if(isset($_GET['order']))
  $order = $_GET['order'];
else
  $order = 'DESC';

if($order == 'ASC')
  $op = 'DESC';
else
  $op = 'ASC';


$sql = "SELECT * FROM smash.game g LEFT JOIN smash.users u ON g.winner_user = u.user_id order by $sortby $order";

if (isset($_SESSION['userid']))
        {
                $queryopen = $db->query($sql);

        echo "<div class='container text-center'><h3>Games</h3>";
        echo "<table class='table table-hover table-striped'>";
        echo "<tr><td onclick=\"window.location='gameRecords.php?sortby=game_id&order=".$op."'\">Game ID</td><td onclick=\"window.location='gameRecords.php?sortby=game_date&order=".$op."'\">Game Date</td><td onclick=\"window.location='gameRecords.php?sortby=display_name&order=".$op."'\">Winner</td></tr>";

                foreach($queryopen as $item){
                        echo "<tr><td><a href='gameDetails.php?gameID=".($item['game_id']."'>".$item['game_id']."</a></td><td>".$item['game_date']."</td><td>".$item['display_name']."</td></tr>");
                }
        echo "</table><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='smash.php'><span class='glyphicon glyphicon-tower'></span> Smash Home</button>
        </div>";

        }
else
        header("location: ../users/signin.php");

include('../footer.php');
echo "</div></body></html>";
?>
