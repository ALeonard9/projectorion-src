<?php
require '../composer/vendor/autoload.php';
$searchafter = urlencode($search);
$response = Unirest\Request::get("http://api.tvmaze.com/search/shows?q=lost",
  array(
    "Accept" => "application/json"
  )
);
$json = json_decode($response->raw_body, true);

print_r(current($json[0]['show']['image']));
?>
