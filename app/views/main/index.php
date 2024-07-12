<?php require_once 'app/views/templates/headerPublic.php'; ?>
<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to SH Movies</h1>
        <p class="lead">Explore movies, rate them, and get AI-generated reviews.</p>
    </div>

    <div class="movie-section">
        <h2>What's On Now</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="path_to_movie_image" class="card-img-top" alt="Movie Image">
                    <div class="card-body">
                        <h5 class="card-title">Movie Title</h5>
                        <p class="card-text">Short description or genre.</p>
                    </div>
                </div>
            </div>
            <!-- Repeat for other movies -->
        </div>
    </div>

    <div class="movie-section">
        <h2>Popular Shows</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <img src="path_to_show_image" class="card-img-top" alt="Show Image">
                    <div class="card-body">
                        <h5 class="card-title">Show Title</h5>
                        <p class="card-text">Short description or genre.</p>
                    </div>
                </div>
            </div>
            <!-- Repeat for other shows -->
        </div>
    </div>
</div>
</body>
</html>
