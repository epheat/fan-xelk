<html>
<?php

  if (isset($_GET['sport']) && isset($_GET['season'])) {
    $sportparam = $_GET['sport'];
    $seasonparam = $_GET['season'];
    $searchparam = "none"; // got this idea from Zack Arnett
    if (isset($_GET['searchterm'])) {
      $searchparam = $_GET['searchterm'];
    }

    $sports = json_decode(file_get_contents('Sports.json'), true);

    $foundresults = false;

    foreach ($sports['sport'] as $sport) { // looking for the desired results json file
      if ($sport['title'] == $sportparam) {
        foreach ($sport['results'] as $resultyear => $resultjson) {
          if ($resultyear == $seasonparam) {
            $foundresults = true;
            showResults($resultjson, $searchparam);
          }
        }
      }
    }

    if (!$foundresults) {
      echo "<h1>No results found for those search parameters.</h1>";
    }

  } else {
    echo "<h1>Incorrect search parameters</h1>";
  }


  function showResults($seasonJSON, $searchterm) {
    if (file_exists($seasonJSON)) { // if the season file exists
      $season = json_decode(file_get_contents($seasonJSON), true);
      if (json_last_error() == JSON_ERROR_NONE) { // and there were no errors reading the file
        // main part of the function here
        // print out "comments" as the title of the HTML page
        echo "<h1>";
        foreach ($season['comments'] as $comment) {
          echo $comment . " ";
        }
        echo "</h1>";

        // iterate over the games and print each game's results in a readable format.

        $wins = 0;
        $losses = 0;

        echo '<div id="resultsList">';
        foreach ($season['games'] as $game) {
          if ($game['WinorLose'] == 'W') {
            $wins++;
            printGame($game, $searchterm, true);
          } else {
            $losses++;
            printGame($game, $searchterm, false);
          }
        }
        echo '</div>';

        // print wins/losses and win percentage
        echo '<div id="winloss">';
        echo 'Wins: ' . $wins . '<br>Losses: ' . $losses . '<br>Win Percentage: ' . ($wins / ($wins + $losses))*100 . '%';
        echo '</div>';

      } else {
        echo "<h1>there was an error reading that JSON file.</h1>";
        echo "<h2>" . json_last_error() . "</h2>";
      }
    } else {
      echo "<h1>That JSON file does not exist.</h1>";
    }
  }

  function printGame($game, $searchterm, $win) {
    if ($win) {
      echo '<div class="game win">';
    } else {
      echo '<div class="game loss">';
    }
    foreach ($game as $key => $value) {
      if ($key == $searchterm) {
        echo "<b>" . $key . ": " . $value . "</b><br>";
      } else {
        echo $key . ": " . $value . "<br>";
      }
    }


    echo '</div>';
  }
?>

</html>
<style>

.game {
  margin: 5px;
  padding: 5px;
  background-color: rgb(214, 208, 208);
  box-shadow: 0px 2px 2px rgb(138, 138, 138);
}

.win {
  background-color: rgb(138, 207, 139);
}
.loss {
  background-color: rgb(207, 133, 133);
}

#winloss {
  margin: 5px;
  padding: 5px;
  background-color: rgb(177, 184, 104);
  box-shadow: 0px 2px 2px rgb(138, 138, 138);
}


</style>
