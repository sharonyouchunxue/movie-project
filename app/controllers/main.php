<?php

require_once 'app/models/Api.php';

class Main extends Controller
{
    private $apiModel;

    public function __construct() {
        $this->apiModel = new Api();
    }

    public function index() {
        $this->view('main/index');
    }
}