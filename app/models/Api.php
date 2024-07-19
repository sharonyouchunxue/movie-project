<?php

class Api {

    private $apiKey; // OMDB API key
    private $geminiApiKey; // Gemini API key
    private $baseUrls; // Base URLs for the APIs

    //initialize API keys and base URLs
    public function __construct() {
        $this->apiKey = $_ENV['omdb_key']; // Set OMDB API key
        $this->geminiApiKey = $_ENV['GEMINI']; // Set Gemini API key
        $this->baseUrls = [
            'omdb' => 'http://www.omdbapi.com/?apikey=' . $this->apiKey . '&t=',
            'gemini' => 'https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=' . $this->geminiApiKey
        ];
    }

    // Fetch movie data from OMDB API
    public function fetchMovieData($title, $source = 'omdb') {
        // Check if the API source is supported
        if (!isset($this->baseUrls[$source])) {
            throw new Exception("API source not supported");
        }

        // Construct the query URL
        $queryUrl = $this->baseUrls[$source] . urlencode($title);
        // Fetch data from the API
        $json = file_get_contents($queryUrl);
        if ($json === FALSE) {
            throw new Exception("Error fetching data from API");
        }

        // Decode the JSON response
        $phpObj = json_decode($json);
        if ($phpObj === NULL) {
            throw new Exception("Error decoding JSON");
        }

        // Return the decoded response as an associative array
        return (array) $phpObj;
    }

    // Fetch multiple movie data from OMDB API
    public function fetchMultipleMovies($titles, $source = 'omdb') {
        $movies = [];
        // Loop through each title and fetch its data
        foreach ($titles as $title) {
            try {
                $movies[] = $this->fetchMovieData($title, $source);
            } catch (Exception $e) {
                continue;
            }
        }
        return $movies;
    }

    // Fetch Ai generated review from Gemini API
    public function fetchReview($movieTitle) {
        // Prepare the request payload
        $data = array(
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => "Generate a review for the movie: " . $movieTitle]
                    ]
                ]
            ]
        );

        // Convert the payload to JSON
        $json_data = json_encode($data);

        // Initialize a cURL session
        $ch = curl_init($this->baseUrls['gemini']);
        // Set cURL options
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Execute the cURL request
        $response = curl_exec($ch);
        curl_close($ch);

        // Check if the request was successful
        if ($response === FALSE) {
            error_log('Error fetching review: ' . curl_error($ch));
            throw new Exception('Error fetching review');
        }

        // Decode the JSON response
        $response_data = json_decode($response, true);

        // Adapt the response structure based on the actual API response format
        return $response_data['candidates'][0]['content']['parts'][0]['text'] ?? 'No review available.';
    }
}
?>
