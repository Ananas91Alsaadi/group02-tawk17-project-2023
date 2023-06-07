<?php


require_once __DIR__ . "/../Template.php";
require_once __DIR__ . "/../../movieDB-api/movieDBAPI.php";
require_once __DIR__ . "/../../movieDB-api/autocompleteAPI.php";

$topMovies= [];

$home_path = getHomePath();
$path_parts = explode("/", $home_path);

$home_path =($path_parts[1]);


Template::header("movies"); 

?>


  <form id="myForm" action=""  method="post">
  <label for="site-search">Search movie:</label>
  <input type="text" id="myInput" name="search" placeholder="Enter your search" oninput="searchMovies(this.value,  '<?= $home_path ?>')">
</form>

<!--
<form action="" method="post">
<label for="site-search">Search movie:</label>
<input type="text" id="myInput" name="search" placeholder="Enter your search" oninput="getTopMoviesByletter(this.value)">
</form>
<?php if ($topMovies) : ?>
  <?php endif; ?>

-->
<ul > 


<?php foreach ($topMovies as $movie) : ?>
<li> 

<?= $original_language = isset($movie['original_language'])? $movie['original_language']:'' ?>


</li>
<br>
<?php endforeach; ?>

</ul>

<ul id ="sug"> </ul>



<?php Template::footer(); ?>