<?php

class Api {

    private $apiKey;
    private $baseUrls;

    public function __construct() {
        $this->apiKey = $_ENV['omdb_key']; // Set with OMDB API key
        $this->baseUrls = [
            'omdb' => 'http://www.omdbapi.com/?apikey=' . $this->apiKey . '&t='
        ];
    }

    //fetch movie data from OMDB API
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

    //fetche multiple movie data from OMDB API
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

}
