<?php
include '../../connectToDB.php';

function nameDeck($deck_id123)
  {
    include '../../connectToDB.php';
    $sql1 = "SELECT * FROM smash.deck d where d.deck_id=".$deck_id123;
    $query1 = $db->query($sql1);
    $res = $query1->fetch();
    $faction_name = $res['faction_name'];
    return $faction_name;
  }
function nameUser($user_id)
  {
    include '../../connectToDB.php';
    $sql = "SELECT * FROM smash.users u where u.users_id=".$user_id;
    $query = $db->query($sql);
    $res = $query->fetch();
    $display_name = $res['display_name'];
    return $display_name;
  }

 function deleteGame($game_id)
  {
    include '../../connectToDB.php';
    $sql = "DELETE FROM `smash`.`game` WHERE `game_id`='". $gameID ."'; DELETE FROM smash.gamelog WHERE l_game_id = '".$gameID."'";
    $db->exec($sql);
    header("Location: gameRecords.php");
    exit;
  }
  function writeMsg() {
      echo "Hello world!";
  }
?>
