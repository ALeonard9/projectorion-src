<?php

$mysql_user = getenv('MYSQL_USER');
$mysql_password = getenv('MYSQL_ROOT_PASSWORD');
$mysql_url = getenv('MYSQL_URL');
$mysql_db = getenv('MYSQL_DATABASE');
$mysql_port = getenv('MYSQL_PORT');
$mysql_connection_string = "mysql:host={$mysql_url};port={$mysql_port};dbname={$mysql_db};charset=utf8";

// isset(getenv('MYSQL_PORT')) ? $_GET['name']:'john doe';

try {
        $db = new PDO ($mysql_connection_string, $mysql_user, $mysql_password);

        }
        catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
 }
?>