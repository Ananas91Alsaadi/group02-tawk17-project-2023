<?php
require_once __DIR__ . "/../Template.php";
require_once __DIR__ . "/../../movieDB-api/movieDBAPI.php";

$data = $this->model['data'];

$data = array_unique(array_column($data, 'movie_id'));


/*
$movieInfo = movieDBAPI::getMovie($movie_id);
$movieName='';



if (isset($movieInfo['title'])){
    $movieName=$movieInfo['title'];
}else if (isset($movieInfo['name'])){
    $movieName=$movieInfo['name'];

} else {
    $movieName="Not Found";
}
*/
//var_dump($data) ;

Template::header("Home");
?>

<h1>Welcome to Movie Review</h1>
<p> Here are our top rated movie on <span class="Scolor"> our website </span>:</p>

<div>
    <div></div>

</div>

<div class="movie-box">

<?php foreach ($data as $movie) : 
    
    $movieInfo = movieDBAPI::getMovie($movie);
    $movieName='';



    if (isset($movieInfo['title'])){
        $movieName=$movieInfo['title'];
    }else if (isset($movieInfo['name'])){
        $movieName=$movieInfo['name'];
    
    } else {
        $movieName="Not Found";
    }
    $posterPath = isset($movieInfo['poster_path'])? $movieInfo['poster_path']:'';
// Construct the URL for the poster image
$baseUrl = "https://image.tmdb.org/t/p/";
$posterSize = "w500"; // Adjust the size as per your requirements
$posterUrl = $baseUrl . $posterSize . $posterPath;

    ?>
    <a class="home-movie" href="<?= $this->home ?>/movie/<?= $movie ?>">
    <img src="<?= $posterUrl ?>" alt="" class="movie-Img" >

    <?= $movieName ?>

    </a>
<?php endforeach; ?>
</div>


<?php Template::footer(); ?>