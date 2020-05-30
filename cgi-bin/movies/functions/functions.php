<?php
require '../composer/vendor/autoload.php';
date_default_timezone_set('Etc/UTC');

function updateMovie($imdb_id)
  {
    include '../connectToDB.php';

    $api = 'http://www.omdbapi.com/?apikey=98df30f1&i=';
    $apiresponse =  file_get_contents($api.$imdb_id);
    $json = json_decode($apiresponse);
    $title =  $json->{'Title'};
    $rated =  $json->{'Rated'};
    $release_date =  date('Y-m-d H:i:s',strtotime($json->{'Released'}));
    $runtime = preg_replace("/[^0-9]/", "", $json->{'Runtime'} );
    $language =  $json->{'Language'};
    $poster_url =  $json->{'Poster'};
    $rating_imdb =  floatval($json->{'imdbRating'});

    try {
        $stmt = $db->prepare("UPDATE `orion`.`movies` SET `title`= :title, `poster_url`= :poster_url, `release_date` = :release_date, `rated` = :rated,`runtime` = :runtime, `rating_imdb` = :rating_imdb, `language`= :language WHERE `imdb`=:imdb");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->bindParam(':rated', $rated);
        $stmt->bindParam(':runtime', $runtime);
        $stmt->bindParam(':poster_url', $poster_url);
        $stmt->bindParam(':rating_imdb', $rating_imdb);
        $stmt->bindParam(':language', $language);
        $stmt->bindParam(':imdb', $imdb_id);
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