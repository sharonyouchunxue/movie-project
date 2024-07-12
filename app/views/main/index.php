<?php require_once 'app/views/templates/headerPublic.php'; ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to SH Movies</h1>
        <p class="lead">With SH you can search over 20,000 movies, rate them, and generate AI reviews. What are you waiting for?</p>
        <a class="btn btn-primary btn-lg" href="/login" role="button">Sign In</a>
        <a class="btn btn-secondary btn-lg" href="/create" role="button">Sign Up</a>
    </div>

    <div class="movie-section">
        <h2>What's On Now</h2>
        <div class="row">
            <?php if (isset($movies) && count($movies) > 0): ?>
                <?php foreach ($movies as $movie): ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="card-img-top" alt="Movie Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($movie['Title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($movie['Genre']); ?></p>
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
</body>
</html>
