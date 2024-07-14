<?php

class Api {

    private $apiKey;
    private $geminiApiKey;
    private $baseUrls;

    public function __construct() {
        $this->apiKey = $_ENV['omdb_key']; // Set with OMDB API key
        $this->geminiApiKey = $_ENV['GEMINI']; // Set with Gemini API key
        $this->baseUrls = [
            'omdb' => 'http://www.omdbapi.com/?apikey=' . $this->apiKey . '&t=',
            'gemini' => 'https://generativelanguage.googleapis.com/v1/models/gemini-pro:generateContent?key=' . $this->geminiApiKey
        ];
    }

    // Fetch movie data from OMDB API
    public function fetchMovieData($title, $source = 'omdb') {
        if (!isset($this->baseUrls[$source])) {
            throw new Exception("API source not supported");
        }

        $queryUrl = $this->baseUrls[$source] . urlencode($title);
        $json = file_get_contents($queryUrl);
        if ($json === FALSE) {
            throw new Exception("Error fetching data from API");
        }

        $phpObj = json_decode($json);
        if ($phpObj === NULL) {
            throw new Exception("Error decoding JSON");
        }

        return (array) $phpObj;
    }

    // Fetch multiple movie data from OMDB API
    public function fetchMultipleMovies($titles, $source = 'omdb') {
        $movies = [];
        foreach ($titles as $title) {
            try {
                $movies[] = $this->fetchMovieData($title, $source);
            } catch (Exception $e) {
                continue;
            }
        }
        return $movies;
    }

    // Fetch AI-generated review from Gemini API
    public function fetchReview($movieTitle) {
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

        $json_data = json_encode($data);

        $ch = curl_init($this->baseUrls['gemini']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === FALSE) {
            error_log('Error fetching review: ' . curl_error($ch));
            throw new Exception('Error fetching review');
        }

        error_log('Raw API Response: ' . $response); // Log the raw response for debugging

        $response_data = json_decode($response, true);

        // Adapt the response structure based on the actual API response format
        return $response_data['candidates'][0]['content']['parts'][0]['text'] ?? 'No review available.';
    }
}
