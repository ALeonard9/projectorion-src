<?php
require '../composer/vendor/autoload.php';
date_default_timezone_set('Etc/UTC');

function updateNotes($g_id, $textbox)
  {
    include '../connectToDB.php';
    
    try {
        $stmt = $db->prepare("UPDATE `orion`.`g_user_countries` SET `notes`=:textbox WHERE `g_id`=:g_id");
        $stmt->bindParam(':g_id', $g_id);
        $stmt->bindParam(':textbox', $textbox);
        $result = $stmt->execute();
        if ( false===$result ) {
          error_log( serialize ($stmt->errorInfo()));
      }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return;
  }

?>