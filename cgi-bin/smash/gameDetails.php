<?php

session_start();

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

$sql = "SELECT * FROM smash.game g left join smash.users u on g.winner_user = u.user_id where  game_id=".$gameID;

$sql2 = "SELECT * FROM smash.users";

$sql3 = "SELECT l.l_user_id AS user, l.l_deck_id AS deck1, k.l_deck_id AS deck2 FROM smash.gamelog l, smash.gamelog k WHERE l.l_game_id = k.l_game_id AND l.l_user_id = k.l_user_id AND l.l_deck_id < k.l_deck_id AND l.l_game_id =".$gameID;

if (isset($_SESSION['username']))
	{
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
          if ($item['winner_user'] == $thing['user_id'])
          {
            echo "selected='selected' ";
          }
           echo "value=".$thing['user_id'].">".$thing['display_name']."</option>";
        }
       }
      echo" </select>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Submit</button>
  	<button class='btn btn-lg btn-warning btn-block' type='button' onclick=location.href='gameRecords.php'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>";

  if ($_SESSION['usergroup']=="Admin")
  {
    echo "	<button class='btn btn-lg btn-danger btn-block' name='delete' type='submit'><span class='glyphicon glyphicon-remove'></span> Delete</button>";
  }
	echo "</form></div>";
  // echo "<br><table><tr><td><u>Player </u></td><td><u>Deck 1 </u></td><td><u>Deck 2 </u></td></tr>";
  // $query3 = $db->query($sql3);
  // foreach($query3 as $stuff){
  //   $sql4 = "SELECT * FROM smash.users u where u.users_id=".$stuff['user'];
  //   $query4 = $db->query($sql4);
  //   $res = $query4->fetch();
  //   $user = $res['display_name'];
  //   $sql1 = "SELECT * FROM smash.deck d where d.deck_id=".$stuff['deck1'];
  //   $query1 = $db->query($sql1);
  //   $res1 = $query1->fetch();
  //   $deck1 = $res1['faction_name'];
  //   $sql5 = "SELECT * FROM smash.deck d where d.deck_id=".$stuff['deck2'];
  //   $query5 = $db->query($sql5);
  //   $res5 = $query5->fetch();
  //   $deck2 = $res5['faction_name'];
    // echo $stuff['user'];
    // $user = nameUser($stuff['user']);
    // echo $user;
    // // $deck1 = nameDeck($stuff['deck1']);
    // // $deck2 = nameDeck($stuff['deck2']);
    // // echo $deck1;
    // echo "<tr><td>".($user."</td><td>".$deck1."</td><td>".$deck2."</td></tr>");
  // }

  // echo "</table>";

	}

else
	{	header("location: ../users/signin.php");}

include('../footer.php');
echo "</div></body></html>";
?>
