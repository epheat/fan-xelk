<html>

<!-- fan-xelk -->
<!-- Evan Heaton & Robert Cala -->
<!-- created on: 11/09/17 -->
<!-- Program 3 for CS316 -->
<?php
  $sports = json_decode(file_get_contents('Sports.json'), true);
?>

<head>
  <title>Fan-Xelk</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <h1>fan-xelk</h1>
  <form id='form' action="search.php" method="get">
    <label>Select a sport: </label>
    <select name="sport">
      <?php
      foreach ($sports['sport'] as $sport) {
        echo '<option value="'.$sport['title'].'">'.$sport['title'].'</option>';
      }
      ?>
    </select><br>
    <label>Select a season: </label>
    <select name="season">
      <?php
      foreach ($sports['sport'] as $sport) {
        foreach ($sport['results'] as $season => $seasonjson) {
          echo '<option value="'.$season.'">'.$season.'</option>';
        }
      }
      ?>
    </select><br>
    <label>Select a search parameter: </label>
    <select name="searchterm">
      <?php
      foreach ($sports['sport'] as $sport) {
        foreach($sport['searchterms'] as $searchterm) {
          echo '<option value="'.$searchterm.'">'.$searchterm.'</option>';
        }
      }
      ?>
    </select><br>
    <input type="submit" value="Search!"/>
  </form>

</body>
<style>
h1 {
  text-align: center;
}
#form {
  margin: 0 auto;
  max-width: 400px;
  background-color: rgb(219, 219, 219);
}

</style>

</html>
