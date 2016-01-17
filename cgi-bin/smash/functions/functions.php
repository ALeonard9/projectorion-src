<?php
include '../../connectToDB.php';

function nameDeck($deck_id, $db)
  {
    $sql1 = "SELECT * FROM smash.deck d where d.deck_id=".$deck_id;
    $query1 = $db->query($sql1);
    $res = $query1->fetch();
    $faction_name = $res['faction_name'];
    return $faction_name;
  }
function nameUser($user_id, $db)
  {
    $sql = "SELECT * FROM `orion`.`users` u where u.id=".$user_id;
    $query = $db->query($sql);
    $res = $query->fetch();
    $display_name = $res['display_name'];
    return $display_name;
  }


?>
