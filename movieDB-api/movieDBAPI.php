<?php

require_once __DIR__ . "/../api/RestAPI.php";

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

   // https://api.themoviedb.org/3/search/multi?api_key=a59c8f7b02647ddf96bb679b651d2d37&language=en-US&query=aaa&page=1&include_adult=false
    public static function getTopMovieByName($query)
    {


      $apiKey = 'a59c8f7b02647ddf96bb679b651d2d37';

      $url = "https://api.themoviedb.org/3/search/multi?api_key={$apiKey}&language=en-US&query={$query}&page=1&include_adult=false";

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
      //$data = $response;
      // Handle the response data

      return $data;

    }


}



?>
