<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
        <title id='pageTitle'>Adam Leonard</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if (isset($_SESSION['userid'])) {

    $user_id = $_SESSION['userid'];
}

$sql = "SELECT * FROM orion.users WHERE id=" . $user_id;


if (isset($_SESSION['userid'])) {
    $query = $db->query($sql);
    foreach ($query as $item) {
        echo "<div class='col-md-3'></div><div class='col-md-6'>
      <form class='form-signin' action='profile.php' id='myForm2' method='POST'>
    <div class='form-group'>
      <label for='email'>Email</label>
      <input type='email' class='form-control' name='email' value='" . $item['email'] . "' readonly>
    </div>
    <div class='form-group'>
      <label for='group'>Group</label>
      <input type='text' class='form-control' name='Group' value='" . $item['user_group'] . "' readonly>
    </div>
    <div class='form-group'>
      <label for='display_name'>Display Name</label>
      <input type='text' class='form-control' name='display_name' value='" . $item['display_name'] . "'>
    </div>
    <button class='btn btn-lg btn-inverse btn-block' name='update' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Update</button>";
    }
    echo "</form></br><button class='btn btn-lg btn-inverse btn-block' onclick=location.href='changepassword.php'><span class='glyphicon glyphicon-pencil'></span> Change Password</button></div>";
    include('../footer.php');
    echo "</div></body></html>";
    if (isset($_POST['display_name'])){
      $name = $_POST['display_name'];
      $sql = "UPDATE `orion`.`users` SET `display_name`=\"".$name."\" WHERE `id`='".$user_id."'";
      $db->exec($sql);
      $_SESSION['username']=$name;
      header("Location: profile.php");
      exit;
    }

}

else {
    header("location: ../users/signin.php");
}

?>
