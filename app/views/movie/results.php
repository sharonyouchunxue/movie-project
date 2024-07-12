<?php require_once 'app/views/templates/headerPublic.php'; ?>
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
            </div>
            <div class="mt-4">
                <h2>Rate This Movie</h2>
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
            </div>
            <div class="mt-4">
                <h2>AI-Generated Review</h2>
                <form method="POST" action="/movie/review">
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($movie['Title']); ?>">
                    <button type="submit" class="btn btn-success">Get Review</button>
                </form>
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
                        <img src="path_to_actor_images/<?php echo htmlspecialchars($actor); ?>.jpg" class="img-fluid" alt="<?php echo htmlspecialchars($actor); ?>">
                        <p class="cast-name"><?php echo htmlspecialchars($actor); ?></p>
                    </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>
