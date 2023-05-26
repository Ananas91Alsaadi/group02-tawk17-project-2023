<?php
require_once __DIR__ . "/RestAPI.php";

class movieDBAPI extends RestAPI
{

    public static function getMovie($movieId)
    {

        $apiKey = 'a59c8f7b02647ddf96bb679b651d2d37';

        $url = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
        
        $response = curl_exec($curl);
        if ($response === false) {
            // Handle the error
            $error = curl_error($curl);
            curl_close($curl);
            die('Error: ' . $error);
        }
        
        curl_close($curl);
        
        $data = json_decode($response, true);
        
        // Handle the response data
        //var_dump($data);
        return $data;
    }


    public static function getTopMovieByName($query)
    {
      $apiKey = 'a59c8f7b02647ddf96bb679b651d2d37';

      $apiBaseUrl = 'https://api.themoviedb.org/3';
      $searchEndpoint = '/search/movie';
      
      // Get the search query from the frontend
      $query = $_GET['query'];
      
      // Make the API request
      $url = $apiBaseUrl . $searchEndpoint . '?api_key=' . $apiKey . '&query=' . urlencode($query);
      $response = file_get_contents($url);
      $data = json_decode($response, true);
      
      // Extract the movie titles from the API response
      $results = [];
      if (!empty($data['results'])) {
          foreach ($data['results'] as $movie) {
              $results[] = $movie['title'];
          }
      }
      
      // Return the results as JSON
      header('Content-Type: application/json');
      return json_encode($results);
    
    }


}

/*

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.themoviedb.org/3/search/multi?api_key=xx&language=en-US&query=xx&page=1&include_adult=false",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhNTljOGY3YjAyNjQ3ZGRmOTZiYjY3OWI2NTFkMmQzNyIsInN1YiI6IjY0NTc3OGY1MTU2Y2M3MDEzZmYwYTUyNCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.Zm9F0eTs4APEJrKTOVO73YHlQRvFqo56DYPRXsok5_M",
    "User-Agent: Thunder Client (https://www.thunderclient.com)"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}*/

?>
