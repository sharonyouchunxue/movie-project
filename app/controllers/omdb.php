<?php

class Omdb extends Controller {

    public function index() {
        // Check if the 'title' parameter is provided in the GET request
        if (isset($_GET['title'])) {
            // Construct the query URL for the OMDB API 
            $query_url = "http://www.omdbapi.com/?apikey=" . $_ENV['omdb_key'] . "&t=" . urlencode($_GET['title']);

            // Fetch the JSON response from the OMDB API
            $json = file_get_contents($query_url);

            // Decode the JSON response into a PHP object
            $phpObj = json_decode($json);

            // Convert the PHP object into an associative array
            $movie = (array) $phpObj;

            // Set the content type of the response to JSON
            header('Content-Type: application/json');

            // Encode the movie array into a JSON string and output it
            echo json_encode($movie);
        } else {
            // If no movie title is provided, return an error message as JSON
            echo json_encode(['error' => 'No movie title provided']);
        }
    }
}
?>
