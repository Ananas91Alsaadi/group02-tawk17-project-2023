<?php


require_once __DIR__ . "/../Template.php";
require_once __DIR__ . "/../../api/movieDBAPI.php";
require_once __DIR__ . "/../../api/autocompleteAPI.php";

$topMovies= [];

Template::header("movies"); 

?>


  <form id="myForm" action=""  method="post">
  <label for="site-search">Search movie:</label>
  <input type="text" id="myInput" name="search" placeholder="Enter your search" oninput="searchMovies(this.value)">
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