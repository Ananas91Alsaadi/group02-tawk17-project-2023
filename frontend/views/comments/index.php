<?php
require_once __DIR__ . "/../../Template.php";
require_once __DIR__ . "/../../../movieDB-api/movieDBAPI.php";


$data = $this->model[0];

$movieInfo = movieDBAPI::getMovie($data->movie_id);

$movieName='';

$genres = isset($movieInfo['genres'])? $movieInfo['genres']:[];

$posterPath = isset($movieInfo['poster_path'])? $movieInfo['poster_path']:'';
// Construct the URL for the poster image
$baseUrl = "https://image.tmdb.org/t/p/";
$posterSize = "w500"; // Adjust the size as per your requirements
$posterUrl = $baseUrl . $posterSize . $posterPath;

$release_date = isset($movieInfo['release_date'])? $movieInfo['release_date']:'';
$original_language = isset($movieInfo['original_language'])? $movieInfo['original_language']:'';

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
    
     </div>
    </div>
    <br>
    
    <h1>My Comment:</h1>
    
    <br>


    <form action="<?= $this->home ?>/comments/<?= $data->comment_id ?>/edit" method="post" class="rate-box">
    <textarea class="comment-area" maxlength="500" name="comment_text"><?= $data->comment_text ?></textarea>  <br>
    <br>

    My Rate:
 <div class="rating-stars" onload="">
    <input type="radio" id="star1" name="rate" value="1" onchange="changeColor(this.value)" <?php if($data->rate== 1) { echo 'checked';} ?>/>
    <label for="star1" class="rating-labels"></label>
    <input type="radio" id="star2" name="rate" value="2" onchange="changeColor(this.value)" <?php if($data->rate== 2) { echo 'checked';} ?> />
    <label for="star2" class="rating-labels"></label>
    <input type="radio" id="star3" name="rate" value="3" onchange="changeColor(this.value)" <?php if($data->rate== 3) { echo 'checked';} ?> />
    <label for="star3" class="rating-labels"></label>
    <input type="radio" id="star4" name="rate" value="4" onchange="changeColor(this.value)"<?php if($data->rate== 4) { echo 'checked';} ?>/>
    <label for="star4" class="rating-labels"></label>
    <input type="radio" id="star5" name="rate" value="5" onchange="changeColor(this.value)"<?php if($data->rate== 5) { echo 'checked';} ?>/>
    <label for="star5" class="rating-labels"></label>
  </div>

  <br>  <br>
  <br>  <br>

    <input type="submit" value="Save" class="btn">
    </form>

    
    <?php else: ?>
    
    <h1>The movie was not found in the database. Please try another one.</h1>
    
    <?php endif; ?>




<script>

changeColor(<?= $data->rate ?>);


</script>



<?php Template::footer(); ?>