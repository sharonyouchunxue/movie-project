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

        if (!isset($_REQUEST['movie'])) {
            header('Location: /movie');
            exit;
        }

        $api = $this->apiModel;
        $movie_title = $_REQUEST['movie'];
        try {
            $movie = $api->fetchMovieData($movie_title);
            $this->view('movie/results', ['movie' => $movie]);
        } catch (Exception $e) {
            $this->view('movie/results', ['error' => $e->getMessage()]);
        }
    }
}
