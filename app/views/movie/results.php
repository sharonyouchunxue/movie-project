<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4"><?php echo htmlspecialchars($movie['Title']); ?></h1>
    <div class="row">
        <div class="col-md-4">
            <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="img-fluid" alt="Movie Poster">
        </div>
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item"><strong>Year:</strong> <?php echo htmlspecialchars($movie['Year']); ?></li>
                <li class="list-group-item"><strong>Rated:</strong> <?php echo htmlspecialchars($movie['Rated']); ?></li>
                <li class="list-group-item"><strong>Released:</strong> <?php echo htmlspecialchars($movie['Released']); ?></li>
                <li class="list-group-item"><strong>Runtime:</strong> <?php echo htmlspecialchars($movie['Runtime']); ?></li>
                <li class="list-group-item"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['Genre']); ?></li>
                <li class="list-group-item"><strong>Director:</strong> <?php echo htmlspecialchars($movie['Director']); ?></li>
                <li class="list-group-item"><strong>Writer:</strong> <?php echo htmlspecialchars($movie['Writer']); ?></li>
                <li class="list-group-item"><strong>Actors:</strong> <?php echo htmlspecialchars($movie['Actors']); ?></li>
                <li class="list-group-item"><strong>Plot:</strong> <?php echo htmlspecialchars($movie['Plot']); ?></li>
                <li class="list-group-item"><strong>Language:</strong> <?php echo htmlspecialchars($movie['Language']); ?></li>
                <li class="list-group-item"><strong>Country:</strong> <?php echo htmlspecialchars($movie['Country']); ?></li>
                <li class="list-group-item"><strong>Awards:</strong> <?php echo htmlspecialchars($movie['Awards']); ?></li>
            </ul>
        </div>
    </div>
    <div class="mt-4">
        <h2>Ratings</h2>
        <?php foreach ($movie['Ratings'] as $rating): ?>
            <p><strong><?php echo htmlspecialchars($rating->Source); ?>:</strong> <?php echo htmlspecialchars($rating->Value); ?></p>
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
</body>
</html>
