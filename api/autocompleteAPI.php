

<?php

// Check for a defined constant or specific file inclusion
if (!defined('MOVIE_REVIEWER') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/RestAPI.php";
//require_once __DIR__ . "/../business-logic/AuthService.php";

// Class for handling requests to "api/auth"

class autocompleteAPI extends RestAPI
{

    // Handles the request by calling the appropriate member function
    public function handleRequest()
    {

        // POST: /api/autocomplete
        if ($this->method == "POST" && $this->path_count == 2 && $this->path_parts[1] == "autocomplete") {
            $this->getTopMovies();
        }
  
    }
    
    private function getTopMovies()
    {
        //$test_password = $this->body["password"];


            $apiKey = 'a59c8f7b02647ddf96bb679b651d2d37';
            $apiBaseUrl = 'https://api.themoviedb.org/3';
            $searchEndpoint = '/search/movie';
            
            // Get the search query from the frontend
            $query = $this->body["search"];
            
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



            ?>
