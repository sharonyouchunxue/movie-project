<?php require_once 'app/views/templates/header.php'; ?>

<?php
// Function to generate star ratings
function generateStarRating($rating) {
    $fullStars = floor($rating);
    $halfStar = $rating - $fullStars >= 0.5 ? true : false;
    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

    $starsHtml = '';

    for ($i = 0; $i < $fullStars; $i++) {
        $starsHtml .= '<i class="fas fa-star star-color"></i> ';
    }

    if ($halfStar) {
        $starsHtml .= '<i class="fas fa-star-half-alt star-color"></i> ';
    }

    for ($i = 0; $i < $emptyStars; $i++) {
        $starsHtml .= '<i class="far fa-star star-color"></i> ';
    }

    return $starsHtml;
}
?>

<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome</h1>
                <p class="lead"> <?= date("F jS, Y"); ?></p>
            </div>
        </div>
    </div>

    <div class="movie-section">
        <h2>What's On Now</h2>
        <div class="row">
            <?php if (isset($movies) && count($movies) > 0): ?>
                <?php foreach ($movies as $movie): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <a href="/movie/search?movie=<?php echo urlencode($movie['Title']); ?>">
                                <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="card-img-top" alt="Movie Image">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($movie['Title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($movie['Genre']); ?></p>
                                <div class="star-rating">
                                    <?php
                                    // Fetch average rating from the database
                                    $db = db_connect();
                                    $statement = $db->prepare("SELECT AVG(rating) as average_rating FROM ratings WHERE movie_title = :movie_title");
                                    $statement->bindParam(':movie_title', $movie['Title']);
                                    $statement->execute();
                                    $ratingData = $statement->fetch(PDO::FETCH_ASSOC);

                                    if ($ratingData['average_rating'] > 0) {
                                        echo generateStarRating(round($ratingData['average_rating'], 1));
                                    } else {
                                        echo generateStarRating(0);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No movies to display.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>

<!-- Include Font Awesome for star icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
