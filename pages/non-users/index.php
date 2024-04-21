<?php
require_once "../../config.php";

session_start();

if (isset($_GET['redirect']) && $_GET['redirect'] === 'discussionsuser') {
    if (!isset($_SESSION["user"])) {
        $errorMessage = "You need to be logged in to access the Discussions page.";
        header("refresh:7;url=login.php");
    } else {
        $discussionId = isset($_GET['view_discussion_id']) ? intval($_GET['view_discussion_id']) : 0;
        header("Location: discussionsuser.php?view_discussion_id=" . $discussionId);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planet Art | Home </title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    <link rel="stylesheet" href="/planetart/css/index-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="icon" href="/planetart/images/favicon_io/favicon-32x32.png" type="image/x-icon">
</head>

<body>
    <?php if (isset($errorMessage)) : ?>
        <div id="errorMessage" class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('errorMessage').style.display = 'none';
            }, 7000);
        </script>
    <?php endif; ?>

<header>
    <nav class="navbar">
        <img src="/planetart/images/planetartlogo.png" alt="planet art logo" width="45" height="30" class="logo-img">
        <span class="site-name">Planet Art</span>

        
        <div>
            <a class="btn btn-outline-secondary nav-links current-page" href="index.php">
                Home
            </a>
            <a class="btn btn-outline-secondary nav-links" href="artists.php">
                Artists
            </a>
            <a class="btn btn-outline-secondary nav-links" href="?redirect=discussionsuser">
                Discussions
            </a>
        </div>
                
        <ul class="navbar-nav ml-lg-auto">
            <div class="ml-lg-4">
                <button type="button" class="btn btn-outline-primary login">
                    <span class="default-icon">
                        <img src="/planetart/images/user.png" alt="User Icon" class="user-icon">
                    </span>
                    <span class="hover-icon">
                        <a href="login.php">
                            <img src="/planetart/images/userhover.png" alt="Another Icon" class="user-icon">
                        </a>
                    </span>
                    Login
                </button>
            </div>
        </ul>
    </nav>
</header>

    <div class="background-colour">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="explore-main-text" style="text-align: center;">What do you want to explore?</div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="index-card">
                        <img src="/planetart/images/fritz.jpg" alt="Artists" class="img-fluid">
                        <div class="card-content">
                            <h5>Artists</h5>
                            <p>Explore a vast collection of paintings, drawings and sketches from various artists and styles.</p>
                            <a href="artists.php" class="btn btn-outline-light btn-explore">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="index-card">
                        <img src="/planetart/images/beyonce.jpg" alt="Drawings" class="img-fluid">
                        <div class="card-content">
                            <h5>Music</h5>
                            <p>Immerse yourself in the captivating realm of music and compositions.</p>
                            <a href="musicians" class="btn btn-outline-light btn-explore">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="index-card">
                        <img src="/planetart/images/poetry.jpg" alt="Music" class="img-fluid">
                        <div class="card-content">
                            <h5>Poetry</h5>
                            <p>Experience the beauty and depth of poetic expressions from renowned poets across the globe.</p>
                            <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="index-card">
                        <img src="/planetart/images/mediums.jpg" alt="Artists" class="img-fluid">
                        <div class="card-content">
                            <h5>Mediums</h5>
                            <p>Discover the diverse range of artistic mediums, from oil paints to digital art, and everything in between.</p>
                            <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="index-card">
                        <img src="/planetart/images/art-movements.jpg" alt="Artists" class="img-fluid">
                        <div class="card-content">
                            <h5>Art Movements</h5>
                            <p>Explore the influential art movements that shaped the art world throughout history</p>
                            <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="index-card">
                        <img src="/planetart/images/is-this-cake.jpg" alt="Artists" class="img-fluid">
                        <div class="card-content">
                            <h5>Unconventional art forms</h5>
                            <p>Discover the unexpected and thought-provoking world of unconventional art forms that challenge traditional definitions.</p>
                            <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid weekly-highlights">
            <div class="row">
                <div class="col-12 highlight-background">
                    <div class="highlight-content">
                        <h2 class="section-title">Weekly highlights</h2>
                        <a href="#" class="btn btn-outline-light btn-explore">Read</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container explore-street-view">
            <h2>Explore art from around the world</h2>
                <p>View art collections</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <img src="/planetart/images/Yemisi-Shyllon-Museum-of-Art.png" alt="Taj Mahal" class="card-img-top">
                                    <div class="card-body">
                                    <h5 class="card-title">Yemisi Shyllon Museum of Art</h5>
                                        <p class="card-text">Nigeria</p>
                                        <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="/planetart/images/louvre.jpg" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">Louvre</h5>
                                            <p class="card-text">France</p>
                                            <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <img src="/planetart/images/van-gogh-museum.jpg" class="card-img-top">
                                    <div class="card-body">
                                        <h5 class="card-title">Van Gogh Museum</h5>
                                        <p class="card-text">Netherlands</p>
                                    <a href="#" class="btn btn-outline-light btn-explore">Explore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <!-- Latest Discussions -->
            <div class="container latest-posts">
                <h2 class="section-title" style="text-align: center;">Latest Discussions</h2>
                <div class="row">
                    <?php
                    // Fetch the latest discussions from the database
                    $sqlLatestDiscussions = "SELECT * FROM discussions ORDER BY created_at DESC LIMIT 3";
                    $resultLatestDiscussions = mysqli_query($conn, $sqlLatestDiscussions);

                    while ($discussion = mysqli_fetch_assoc($resultLatestDiscussions)) {
                        echo '<div class="col-md-4">';
                        echo '<div class="post-card">';
                        echo '<h4>' . htmlspecialchars($discussion['discussion_topic']) . '</h4>';
                        echo '<p>' . htmlspecialchars(substr($discussion['thoughts'], 0, 100)) . '...</p>';
                        echo '<a href="?redirect=discussionsuser&view_discussion_id=' . $discussion['id'] . '" class="btn btn-outline-primary login">Read More</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                <div class="artform-card">
                    <div class="artform-header text-center">
                    <h2>Want your art to be featured on PlanetArt?</h2>
                    </div>
                    <div class="artform-body">
                    <p class="lead artform-lead text-center">Send us an email!</p>
                    <form>
                        <div class="form-group">
                        <label for="artform-name" class="artform-label">Name</label>
                        <input type="text" class="form-control artform-input" id="artform-name" placeholder="Enter your name">
                        </div>
                        <div class="form-group">
                        <label for="artform-email" class="artform-label">Email</label>
                        <input type="email" class="form-control artform-input" id="artform-email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                        <label for="artform-message" class="artform-label">Message</label>
                        <textarea class="form-control artform-textarea" id="artform-message" rows="3" placeholder="Tell us about your art"></textarea>
                        </div>
                        <div class="text-center">
                        <button type="button" class="btn btn-outline-primary login" style="margin-top: 20px;">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer p-3">
            © 2024
            <a>Planet Art</a>
            <a href="privacy-policy.php" class="privacy-policy-link">Privacy Policy</a>
        </div>
    </footer>

    
    <!-- Bootstrap js and popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"
        integrity="sha384-X48EVOIu1KKPHFG0f/RaN8GGVGa2NgqzqXf8+2Vb9sUmXsLGee4JSChHX3U8PVIe"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

</body>
</html>