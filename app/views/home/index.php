<?php require_once 'app/views/templates/header.php'; ?>

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
                        <a href="/movie/search?movie=<?php echo urlencode($movie['Title']); ?>" class="text-decoration-none">
                            <div class="card">
                                <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="card-img-top" alt="Movie Image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($movie['Title']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($movie['Genre']); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No movies to display.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
