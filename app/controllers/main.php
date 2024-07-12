<?php

require_once 'app/models/Api.php';

class Main extends Controller
{
    private $apiModel;

    public function __construct() {
        $this->apiModel = new Api();
    }

    public function index() {
        $titles = ["Despicable Me 4", "Touch", "It Ends With Us", "Jatt & Juliet 3", "The Garfield Movie", "Kingdom of the Planet of the Apes", "The Wild Robot", "Inside Out 2"]; 
        $movies = $this->apiModel->fetchMultipleMovies($titles);
        $this->view('main/index', ['movies' => $movies]);
    }
}
