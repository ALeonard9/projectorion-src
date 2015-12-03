<?php

session_start();

include '../connectToDB.php';

$type = $_GET['type'];

$sqlfart = "INSERT INTO `bet`.`history` (`betDescription`, `betAmount`, `betWinner`, `betStatus`) VALUES ('Quick Win S', '10', 'Soumya', 'Complete')";
$sqlpick = "INSERT INTO `bet`.`history` (`betDescription`, `betAmount`, `betWinner`, `betStatus`) VALUES ('Quick Win A', '10', 'Adam', 'Complete')";

switch ($type) {
        case "fart":
                $sql = $sqlfart;
                break;
        case "pick":
                $sql = $sqlpick;
                break;
}


if ($_SESSION['username'])
        {
                $db->exec($sql);
                header("Location: betting.php");
                exit;
        }
else
        {
        die("You must login");
        }
?>
