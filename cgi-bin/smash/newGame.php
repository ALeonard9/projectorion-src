<?php

session_start();
ob_start();

include '../connectToDB.php';

echo "<html lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
        <title id='pageTitle'>Smash Tracker</title>";
include('../header.php');
echo "</head><body><div class='container'>";
include('../navigation.php');

if (isset($_SESSION['userid']))
	{
	echo"<div class='col-md-3'></div><div class='col-md-6'><script type='text/javascript'>
          function checkNumPlayers(selectedType){
            document.getElementById('u1').style.display = 'none';
            document.getElementById('u2').style.display = 'none';
            document.getElementById('u3').style.display = 'none';
            document.getElementById('u4').style.display = 'none';
            for (i = 1; i <= selectedType; i++) {
              document.getElementById('u'+ i).style.display = 'block';
            }
          }
  </script>
	<form class='form-signin' action='newGamePlayers.php' form='thisForm' method='POST'>
    <div class='form-group'>
      <label for='description'>How many players? (2-4)</label>
      <input type='number' class='form-control' name='num_players' min='2' max='4' oninput='checkNumPlayers(this.value)'>
    </div>";
    $x = 1;
    $y = 4;
    while($x <= $y) {
        echo "
        <div class='form-group' id='u".$x."' style='display:none'>
          <label for='nuser".$x."'>User ".$x."</label>
          <select class='form-control' name='nuser".$x."'>
            <option disabled='disabled' selected='selected'>Select Player</option>";
            $sql = "select * from orion.users order by display_name";
            $queryopen = $db->query($sql);
            foreach($queryopen as $item){
                    echo "<option
                    value=".($item['id'].">".$item['display_name']."</option>");
            };
            echo "</select></div>";
                $x++;
            }

	echo"<button class='btn btn-lg btn-inverse btn-block' type='submit'><span class='glyphicon glyphicon-ok-sign'></span> Submit</button>
  	<button class='btn btn-lg btn-warning btn-block' onClick='history.go(-1);return true;'><span class='glyphicon glyphicon-remove-sign'></span> Cancel</button>
    </form></div";

	}
else
	{
	header("location: ../users/signin.php");
	}
include('../footer.php');
echo "</div></body></html>";
?>
