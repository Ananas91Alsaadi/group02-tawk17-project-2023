<?php
require_once __DIR__ . "/../Template.php";
require_once __DIR__ . "/../../api/movieDBAPI.php";

$movieInfo = movieDBAPI::getMovie($this->model['id']);
$movieName='';

$genres = isset($movieInfo['genres'])? $movieInfo['genres']:[];

$posterPath = isset($movieInfo['poster_path'])? $movieInfo['poster_path']:'';
// Construct the URL for the poster image
$baseUrl = "https://image.tmdb.org/t/p/";
$posterSize = "w500"; // Adjust the size as per your requirements
$posterUrl = $baseUrl . $posterSize . $posterPath;

$release_date = isset($movieInfo['release_date'])? $movieInfo['release_date']:'';
$original_language = isset($movieInfo['original_language'])? $movieInfo['original_language']:'';

$sum = 0; // Calculate the sum of the numbers
$count = 0; // Count the number of elements

foreach ($this->model['data'] as $innerArray) {
    if (isset($innerArray->rate) && is_numeric($innerArray->rate)) {
      $sum += $innerArray->rate;
      $count++;
    }
  }
if ($count==0) {
$count=1;
}

$averageRate =round($sum / $count, 1);  // Calculate the average


//var_dump($movieInfo);
//echo $movieInfo['title'];

if (isset($movieInfo['title'])){
    $movieName=$movieInfo['title'];
}else if (isset($movieInfo['name'])){
    $movieName=$movieInfo['name'];

} else {
    $movieName="Not Found";
}


Template::header($movieName);
?>
<?php if ($movieName!='Not Found') : ?>




<div class="single-movie">
  <img src="<?= $posterUrl ?>" alt="" id="movieImg" >
  <div>
  <p>Genres: <?php foreach ($genres as $genre) {
    echo $genre['name'] . ", ";
} 


 ?></p>
 <p>
 Release date: <?= $release_date ?>
 </p>
 <p>
 Original language: <?= $original_language ?>
 </p>
 <p>Rate on <span class="Scolor"> our website</span>: <span class="biger-size"><?= $averageRate ?></span>/5</p>  
<br>
 <p><a class="Scolor Sshadow" href="<?= $this->home ?>/comments/<?= $this->model['id'] ?>">Share your thoughts and rate movies on our website to help others discover the best films</a></p>


 </div>
</div>
<br>
<?php if (count( $this->model['data'])>0) : ?>

<h1> Users comments:</h1>

<br>
<?php endif; ?>

<ul class="comments">
<?php foreach ($this->model['data'] as $comment) : ?>
<li> <p> <span class="user-name">     <?= $comment->user_name ?></span></p>  <br>  <?= $comment->comment_text ?>
<?php if (isset( $this->user->user_role) ) : ?>

<?php if ($this->user->user_role === "admin") : ?>


    <form action="<?= $this->home ?>/comments/<?= $comment->comment_id ?>/delete" method="post">
    <input type="submit" value="Delete" class="btn delete-btn">
</form>

<?php endif; ?>

<?php endif; ?>


</li>
<br>
<?php endforeach; ?>


</ul>

<?php else: ?>

<h1>The movie was not found in the database. Please try another one.</h1>

<?php endif; ?>



<?php Template::footer(); ?>