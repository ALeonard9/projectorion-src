<?php

session_start();
ob_start();

include '../connectToDB.php';
include 'functions/functions.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

$gameID = $_GET['gameID'];

$sql = "SELECT * FROM smash.game g left join orion.users u on g.winner_user = u.id where  game_id=".$gameID;

$sql2 = "SELECT distinct u.id, u.display_name FROM smash.gamelog g, orion.users u where g.l_user_id = u.id and l_game_id =".$gameID;

$sql3 = "SELECT l.l_user_id AS user, l.l_deck_id AS deck1, k.l_deck_id AS deck2 FROM smash.gamelog l, smash.gamelog k WHERE l.l_game_id = k.l_game_id AND l.l_user_id = k.l_user_id AND l.l_deck_id < k.l_deck_id AND l.l_game_id =".$gameID;

	$query = $db->query($sql);
	foreach($query as $item){
    echo "<div class='col-md-3'></div><div class='col-md-6'>
  	<form class='form-signin' action='updateGame.php' id='myForm2' method='POST'>
    <div class='form-group'>
      <label for='gameid'>Game ID</label>
      <input type='number' class='form-control' name='gameid' value='".$item['game_id']."' readonly>
    </div>
    <div class='form-group'>
      <label for='date'>Game Date</label>
      <input type='text' class='form-control' name='date' value='".$item['game_date']."' readonly>
    </div>
    <div class='form-group'>
      <label for='notes'>Notes</label>
      <input type='text' class='form-control' name='date' value='".$item['game_notes']."'>
    </div>
    <div class='form-group'>
      <label for='winner'>Winner</label>
      <select class='form-control' name='winner' form='myForm2'>
        <option ";
        if (is_null($item['winner_user']))
        {
          echo "selected='selected' ";
        }
        echo "disabled='disabled' >Select Winner</option>";
        $queryopen = $db->query($sql2);
        foreach($queryopen as $thing){
          echo "<option ";
          if ($item['winner_user'] == $thing['id'])
          {
            echo "selected='selected' ";
          }
           echo "value=".$thing['id'].">".$thing['display_name']."</option>";
        }
       }
      echo" </select>
    </div>";
    $query = $db->query($sql3);
    foreach($query as $item){
      $user = nameUser($item['user'], $db);
      $deck1 = nameDeck($item['deck1'], $db);
      $deck2 = nameDeck($item['deck2'], $db);
      echo "<div class='col-md-6 text-center'><u><h3>".$user."</h3></u>".$deck1."</br>".$deck2."</div>";
    }
if (isset($_SESSION['userid']))
	{
    echo "<button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Submit</button>
  	<button class='btn btn-lg btn-warning btn-block' type='button' onclick=location.href='gameRecords.php'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>";

  if ($_SESSION['usergroup']=="Admin")
  {
    echo "	<button class='btn btn-lg btn-danger btn-block' name='delete' type='submit'><span class='glyphicon glyphicon-remove'></span> Delete</button>";
  }
	echo "</form></div>";
	}

include('../footer.php');
echo "</div></body></html>";
?>
