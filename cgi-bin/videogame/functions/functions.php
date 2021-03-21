<?php
session_start();

require '../composer/vendor/autoload.php';
date_default_timezone_set('Etc/UTC');

function updateVG($igdb_id)
  {
    include '../connectToDB.php';

    $sql = "SELECT igdb_last_update FROM orion.videogames WHERE igdb = ".$igdb_id;
    $query = $db->query($sql);
    $res = $query->fetch();
    $db_last_update = $res['igdb_last_update'];
    if (!isset($_SESSION['twitch_token'])){
      twitchAuth();
    }
    
    $twitch_client_id= getenv('TWITCH_CLIENT_ID');
    $twitch_client_auth= $_SESSION['twitch_token'];
    
    $headers = array(
      "Client-ID" => $twitch_client_id,
      "Authorization" => "Bearer ".$twitch_client_auth,
      "Accept" => "application/json"
    );
    
    $data = "fields name,cover,first_release_date,rating,updated_at,slug; limit 1; where id = $igdb_id;";

    $body = Unirest\Request\Body::form($data);
    $response = Unirest\Request::post('https://api.igdb.com/v4/games', $headers, $body);
    $json = json_decode($response->raw_body, true); 
    
    $vg_updated = date("Y-m-d H:i:s",$json[0]['updated_at']);

    if ($db_last_update == $vg_updated){
        return;
    }

    $vg_name = $json[0]['name'];
    $vg_release = date("Y-m-d H:i:s", $json[0]['first_release_date']);
    $vg_rating = round($json[0]['rating'],2);
    $vg_slug = $json[0]['slug'];

    
    $data = "fields url; where id = ".$json[0]['cover'].";";
    $body = Unirest\Request\Body::form($data);
    $response = Unirest\Request::post('https://api.igdb.com/v4/covers', $headers, $body);
    $json_cover = json_decode($response->raw_body, true);

    $vg_cover = $json_cover[0]['url'];
    
    try {
        $stmt = $db->prepare("UPDATE `orion`.`videogames` SET `title`=:name, `poster_url`=:poster_url, `release_date` = :release_date, `rating` = :rating, `igdb_last_update` = :igdb_last_update, `slug` = :slug WHERE `igdb`=:igdb");
        $stmt->bindParam(':name', $vg_name);
        $stmt->bindParam(':release_date', $vg_release);
        $stmt->bindParam(':poster_url', $vg_cover);
        $stmt->bindParam(':rating', $vg_rating);
        $stmt->bindParam(':igdb', $igdb_id);
        $stmt->bindParam(':igdb_last_update', $vg_updated);
        $stmt->bindParam(':slug', $vg_slug);
        $stmt->execute();
        if ( false===$result ) {
          error_log( serialize ($stmt->errorInfo()));
        }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return;
  }

  function updateNotes($g_id, $textbox)
  {
    include '../connectToDB.php';
    
    try {
        $stmt = $db->prepare("UPDATE `orion`.`g_user_videogames` SET `notes`=:textbox WHERE `g_id`=:g_id");
        $stmt->bindParam(':g_id', $g_id);
        $stmt->bindParam(':textbox', $textbox);
        $stmt->execute();
        if ( false===$result ) {
          error_log( serialize ($stmt->errorInfo()));
      }
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
    return;
  }

  function twitchAuth()
  {
    $twitch_client_id= getenv('TWITCH_CLIENT_ID');
    $twitch_client_secret = getenv('TWITCH_CLIENT_SECRET');
    
    $response = Unirest\Request::post("https://id.twitch.tv/oauth2/token?client_id=$twitch_client_id&client_secret=$twitch_client_secret&grant_type=client_credentials");
    $json = json_decode($response->raw_body, true);
        
    $_SESSION['twitch_token'] = $json['access_token'];
    
    return;
  }

?>