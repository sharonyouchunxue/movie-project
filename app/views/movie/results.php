<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    require_once 'app/views/templates/header.php'; // Private header
} else {
    require_once 'app/views/templates/headerPublic.php'; // Public header
}

error_log('Session user_id: ' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'not set'));

// Fetch average rating from the database
$db = db_connect();
$statement = $db->prepare("SELECT AVG(rating) as average_rating, COUNT(rating) as total_ratings FROM ratings WHERE movie_title = :movie_title");
$statement->bindParam(':movie_title', $movie['Title']);
$statement->execute();
$ratingData = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the user has already rated this movie
$userHasRated = false;
if (isset($_SESSION['user_id'])) {
    $statement = $db->prepare("SELECT * FROM ratings WHERE user_id = :user_id AND movie_title = :movie_title");
    $statement->bindParam(':user_id', $_SESSION['user_id']);
    $statement->bindParam(':movie_title', $movie['Title']);
    $statement->execute();
    $userHasRated = $statement->fetch(PDO::FETCH_ASSOC);
}
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="movie-poster" alt="Movie Poster">
        </div>
        <div class="col-md-8">
            <h1 class="mb-4"><?php echo htmlspecialchars($movie['Title']); ?></h1>
            <p><strong>Directed by:</strong> <?php echo htmlspecialchars($movie['Director']); ?></p>
            <p><strong>Year:</strong> <?php echo htmlspecialchars($movie['Year']); ?></p>
            <p><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['Runtime']); ?></p>
            <p><strong>Rated:</strong> <?php echo htmlspecialchars($movie['Rated']); ?></p>
            <p><strong>Genres:</strong> <?php echo htmlspecialchars($movie['Genre']); ?></p>
            <p><strong>Plot:</strong> <?php echo htmlspecialchars($movie['Plot']); ?></p>
            <div class="rating">
                <h3>Ratings</h3>
                <?php foreach ($movie['Ratings'] as $rating): ?>
                    <span>
                        <?php if ($rating->Source == "Internet Movie Database"): ?>
                            <i class="fas fa-star"></i> IMDb: <?php echo htmlspecialchars($rating->Value); ?>
                        <?php elseif ($rating->Source == "Rotten Tomatoes"): ?>
                            <i class="fas fa-tomato"></i> Rotten Tomatoes: <?php echo htmlspecialchars($rating->Value); ?>
                        <?php elseif ($rating->Source == "Metacritic"): ?>
                            <i class="fas fa-metacritic"></i> Metacritic: <?php echo htmlspecialchars($rating->Value); ?>
                        <?php else: ?>
                            <?php echo htmlspecialchars($rating->Source); ?>: <?php echo htmlspecialchars($rating->Value); ?>
                        <?php endif; ?>
                    </span><br>
                <?php endforeach; ?>

                <?php if ($ratingData['total_ratings'] > 0): ?>
                    <p><strong>Average User Rating:</strong> <?php echo round($ratingData['average_rating'], 1); ?>/5 (<?php echo $ratingData['total_ratings']; ?> ratings)</p>
                <?php else: ?>
                    <p><strong>Average User Rating:</strong> No ratings yet.</p>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <h2>Rate This Movie</h2>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($userHasRated): ?>
                        <p>You have already rated this movie.</p>
                    <?php else: ?>
                        <form method="POST" action="/movie/rate">
                            <div class="form-group">
                                <input type="hidden" name="title" value="<?php echo htmlspecialchars($movie['Title']); ?>">
                                <label for="rating">Your Rating (1-5):</label>
                                <select class="form-control" id="rating" name="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Rating</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Please <a href="/login?returnUrl=<?php echo urlencode('/movie/search?movie=' . htmlspecialchars($movie['Title'])); ?>">log in</a> to rate this movie.</p>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <h2>AI-Generated Review</h2>
                <form method="POST" action="/movie/review">
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($movie['Title']); ?>">
                    <button type="submit" class="btn btn-success">Get Review</button>
                </form>
                <?php if (isset($review)): ?>
                    <div class="review mt-3">
                        <h3>Review for <?php echo htmlspecialchars($movie['Title']); ?>:</h3>
                        <p><?php echo htmlspecialchars($review); ?></p>
                    </div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h2>Cast</h2>
        <div class="row cast">
            <?php
                $actors = explode(', ', $movie['Actors']);
                foreach ($actors as $actor): ?>
                    <div class="col-md-2 text-center">
                        <img src="/path_to_actor_images/<?php echo htmlspecialchars($actor); ?>.jpg" class="img-fluid" alt="<?php echo htmlspecialchars($actor); ?>">
                        <p class="cast-name"><?php echo htmlspecialchars($actor); ?></p>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Toast for displaying messages -->
<div aria-live="polite" aria-atomic="true" style="position: relative;">
    <div class="toast" style="position: fixed; top: 20px; right: 20px; z-index: 1060;">
        <div class="toast-header">
            <strong class="mr-auto">Notification</strong>
            <small>Just now</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?php
            if (isset($_SESSION['success'])) {
                echo $_SESSION['success'];
                unset($_SESSION['success']);
            } elseif (isset($_SESSION['error'])) {
                echo $_SESSION['error'];
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>

<!-- Include Bootstrap JS for Toast functionality -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize the toast
        $('.toast').toast('show');
    });
</script>
