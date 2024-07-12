<?php

class Omdb extends Controller {

    public function index() {
        if (isset($_GET['title'])) {
            $query_url = "http://www.omdbapi.com/?apikey=" . $_ENV['omdb_key'] . "&t=" . urlencode($_GET['title']);
            $json = file_get_contents($query_url);
            $phpObj = json_decode($json);
            $movie = (array) $phpObj;

            header('Content-Type: application/json');
            echo json_encode($movie);
        } else {
            echo json_encode(['error' => 'No movie title provided']);
        }
    }
}