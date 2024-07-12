<?php

require_once 'app/models/Api.php';

class Movie extends Controller {

    private $apiModel;

    public function __construct() {
        $this->apiModel = new Api();
    }

    public function index() {
        $this->view('movie/index');
    }

    public function search() {
        //echo '<pre>Search method called</pre>'; // Debug line
        if (!isset($_REQUEST['movie'])) {
            header('Location: /movie');
            exit;
        }

        $api = $this->apiModel;
        $movie_title = $_REQUEST['movie'];
        try {
            $movie = $api->fetchMovieData($movie_title);
            //echo '<pre>'; print_r($movie); echo '</pre>'; // Debug line
            $this->view('movie/results', ['movie' => $movie]);
        } catch (Exception $e) {
            //echo '<pre>'; print_r($e->getMessage()); echo '</pre>'; // Debug line
            $this->view('movie/results', ['error' => $e->getMessage()]);
        }
    }
}
