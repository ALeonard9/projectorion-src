<?php

session_start();
ob_start();

include '../connectToDB.php';
include 'functions/functions.php';

$user = nameUser(1, $db);
echo $user;

$deck = nameDeck(1, $db);
echo $deck;

?>
