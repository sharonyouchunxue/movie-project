<?php

require_once 'app/models/Api.php';

class Movie extends Controller {

    private $apiModel;

     // Constructor to initialize the API model
    public function __construct() {
        $this->apiModel = new Api();
    }

    // Render the movie index view
    public function index() {
        $this->view('movie/index');
    }

    //Method for movie search
    public function search() {
        // Check if the movie parameter is provided
        if (!isset($_REQUEST['movie'])) {
            // Redirect to the movie index if no movie is specified
            header('Location: /movie');
            exit;
        }

        $api = $this->apiModel;
        $movie_title = $_REQUEST['movie'];
        try {
            // Fetch movie data from the API
            $movie = $api->fetchMovieData($movie_title);
            // Render the movie results view with the fetched movie data
            $this->view('movie/results', ['movie' => $movie]);
        } catch (Exception $e) {
            $this->view('movie/results', ['error' => $e->getMessage()]);
        }
    }

      // Method to handle movie rating
    public function rate() {
           // Ensure session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

           // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        // Get rating data from POST request
        $user_id = $_SESSION['user_id'];
        $movie_title = $_POST['title'];
        $rating = $_POST['rating'];

        // Validate rating value
        if ($rating < 1 || $rating > 5) {
            $_SESSION['error'] = "Invalid rating value.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Check if the user has already rated this movie
        $db = db_connect();
        $statement = $db->prepare("SELECT * FROM ratings WHERE user_id = :user_id AND movie_title = :movie_title");
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':movie_title', $movie_title);
        $statement->execute();
        $existingRating = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            $_SESSION['error'] = "You have already rated this movie.";
        } else {
            // Save new rating to database
            $statement = $db->prepare("INSERT INTO ratings (user_id, movie_title, rating) VALUES (:user_id, :movie_title, :rating)");
            $statement->bindParam(':user_id', $user_id);
            $statement->bindParam(':movie_title', $movie_title);
            $statement->bindParam(':rating', $rating);
            $statement->execute();
            $_SESSION['success'] = "Rating submitted successfully.";
           }

           header('Location: ' . $_SERVER['HTTP_REFERER']);
           exit();
       }

     // Method for AI generated movie reviews
    public function review() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $movie_title = $_POST['title'];

            try {
                 // Fetch movie data from the API
                $api = $this->apiModel;
                $movie = $api->fetchMovieData($movie_title);
                // Fetch Ai generated review from the API
                $review = $api->fetchReview($movie_title);
                 // Render the movie results view with the fetched movie data and revie
                $this->view('movie/results', ['movie' => $movie, 'review' => $review]);
            } catch (Exception $e) {//for error handling
                $this->view('movie/results', ['error' => $e->getMessage()]);
            }
        }
    }


}