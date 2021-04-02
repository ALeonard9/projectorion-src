<?php
require '../composer/vendor/autoload.php';
include '../connectToDB.php';
include 'functions/functions.php';


session_start();
ob_start();
$_SESSION['url'] = $_SERVER['REQUEST_URI'];

if(isset( $_POST['textbox']))
$textbox = $_POST['textbox'];
if(isset( $_POST['g_id']))
$g_id = $_POST['g_id'];
if(isset( $_POST['id']))
$id = $_POST['id'];

updateNotes($g_id, $textbox);

header("location: moviedetails.php?id=".$id);

?>
