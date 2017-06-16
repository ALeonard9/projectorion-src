<!-- Static navbar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="../dashboard.php">The Sandbox</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Apps <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="../bet/betting.php">Betting</a></li>
            <li><a href="../bet/rules.php">Rulebook</a></li>
            <li><a href='../scoreboard/scoreboard.html'>Scoreboard</a></li>
            <li><a href="../smash/smash.php">Smash Up</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Trackers <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href='../dashboard.php'>Dashboard</a></li>
            <li class='divider'></li>
            <li><a href='../books/book.php'> Books</a></li>
            <li><a href='../countries/country.php'> Countries</a></li>
            <li><a href="../movies/movie.php"> Movies</a></li>
            <li><a href="../tv/tv.php"> TV</a></li>
            <li><a href="../videogame/videogame.php"> Video Games</a></li>
          </ul>
        </li>
        <li class='dropdown'>
          <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Games <span class='caret'></span></a>
          <ul class='dropdown-menu'>
            <li><a href='#'>Fleet </a></li>
            <li class='divider'></li>
            <li><a href='../timer'> Timer</a></li>
            <li><a href='../rules'> Rules</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">About <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href='https://www.aleonard.us'>Intro</a></li>
            <li><a href="http://resume.aleonard.us">Resume</a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
<?php  if (isset($_SESSION['userid']))
        {
          echo "<li class='dropdown'>
            <a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>Welcome " . $_SESSION['username'] . " <span class='caret'></span></a>
            <ul class='dropdown-menu'>
              <li><a href='../users/profile.php'>My Profile</a></li>
              <li><a href='../users/logout.php''>Log Out</a></li>
            </ul>
          </li>";
        }
        else
        {
        echo "<li><a href='../users/signin.php'>Sign In</a></li>";
        }
?>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container-fluid -->
</nav>
