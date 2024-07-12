<?php

require_once 'app/models/Api.php';

class Home extends Controller {

    private $apiModel;

    public function __construct() {
        $this->apiModel = new Api();
    }

    public function index(){
        $user = $this->model('User');
        $data = $user->test();

        // Fetch the movies
        $titles = ["Despicable Me 4", "Touch", "It Ends With Us", "House of the Dragon", "The Garfield Movie", "Kingdom of the Planet of the Apes", "The Wild Robot", "Inside Out 2"];
        $movies = $this->apiModel->fetchMultipleMovies($titles);

        // Pass the movies data to the view
        $this->view('home/index', ['movies' => $movies]);
    }
}
