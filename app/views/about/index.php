<?php
if (isset($_SESSION['user_id'])) {
    require_once 'app/views/templates/header.php'; // Private header
} else {
    require_once 'app/views/templates/headerPublic.php'; // Public header
}
?>

<div class="container mt-4 about-page">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Sharon You</h2>
            <p class="text-muted">Founder</p>
            <h1>WHY CHOOSE US</h1>
            <p id="short-description">
                SHDb Movies is a rating and review website that allows users to retrieve information on more than 20,000 movies. You can review any movie you want and share your opinions with others.
            </p>
            <p id="long-description" style="display: none;">
                SHDb Movies is a rating and review website that allows users to retrieve information on more than 20,000 movies. You can review any movie you want and share your opinions with others. Our platform provides detailed information on movies, including ratings from multiple sources, user reviews, and AI-generated reviews. Whether you are a casual moviegoer or a film enthusiast, SHDb Movies offers a comprehensive resource for discovering and evaluating films.
            </p>
            <a href="#" id="read-more" class="btn btn-link">read more</a>
        </div>
        <div class="col-md-6">
            <img src="../app/images/review.jpg" class="img-fluid" alt="SHDb Movies">
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>

<!-- Add the script for the read more functionality here -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var readMore = document.getElementById('read-more');
        var shortDescription = document.getElementById('short-description');
        var longDescription = document.getElementById('long-description');

        readMore.addEventListener('click', function (e) {
            e.preventDefault();
            if (longDescription.style.display === 'none') {
                longDescription.style.display = 'block';
                readMore.textContent = 'read less';
                shortDescription.style.display = 'none';
            } else {
                longDescription.style.display = 'none';
                readMore.textContent = 'read more';
                shortDescription.style.display = 'block';
            }
        });
    });
</script>
</body>
</html>
