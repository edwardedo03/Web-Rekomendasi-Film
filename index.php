<?php
    include("connect_db.php");

    function get_film_for_home($conn) {
        $query = mysqli_query($conn, "SELECT * FROM top_10000_movies LIMIT 108");
        
        if(mysqli_num_rows($query) > 0) {
            return $query;
        } else {
            return "Empty";
        }        
    }

    function get_film_for_recommendation($conn) {
        $query = mysqli_query($conn, "SELECT * FROM top_10000_movies WHERE vote_average > 8.0 ORDER BY RAND() LIMIT 10");
        
        if(mysqli_num_rows($query) > 0) {
            return $query;
        } else {
            return "Empty";
        }        
    }

    function cleaning_genre($row) {
        $genre_clean = $row['genre'];
        $items = array('[', ']', "'");
        $genre_clean = str_replace($items, "", $genre_clean);
        $genre_clean = str_replace(",", " •", $genre_clean);

        return $genre_clean;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies Holic</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="assets/image/logo-remove-bg.png">
</head>
<body>
    <div class="side-navbar">
        <label class="side-nav-button">☰</label>
        <ul class="side-navbar-ul">
            <li><a href="#main">Home</a></li>
            <li class="nav-genre">
                <a href="#main">Genre</a>

                <ul class="dropdown">
                    <li><a href="">• Action</a></li>
                    <li><a href="">• Adventure</a></li>
                    <li><a href="">• Sci-Fi</a></li>
                    <li><a href="">• Crime</a></li>
                    <li><a href="">• Thriller</a></li>
                    <li><a href="">• Horror</a></li>
                    <li><a href="">• Comedy</a></li>
                    <li><a href="">• Family</a></li>
                </ul>
            </li>
            <li><a href="#second-section">About</a></li>
            <li><a href="#main">Favorite</a></li>
            <li><a href="#main">Account</a></li>
        </ul>
    </div>

    <nav id="nav">
        <div></div>
        
        <div class="image-logo">
            <a href="#main"><img src="assets/image/logo-remove-bg.png" width="180px" alt="Film-Holic"></a>
        </div>

        <div class="image-search">
            <img src="assets/icon/search.png" alt="search-logo">
        </div>
    </nav>

    <section id="main">
        <h3>TOP MOVIES</h3>
        <div class="marquee-main-container">
            <div class="marquee">

                <?php
                    $result = get_film_for_recommendation($conn);

                    while($row = mysqli_fetch_assoc($result)) { 

                ?>
                
                <a href="film_detail.php?id=<?php echo $row['id']?>">
                    <div class="image-wrapper">
                        <img src="<?php echo $row['image_url']?>" alt="">
                        <div class="image-text">
                            <p><?php echo $row['title']?></p>
                            <p><?php echo cleaning_genre($row)?></p>
                            <p>⭐ <?php echo $row['vote_average']?></p>
                        </div>
                    </div>
                </a>
            
                <?php } ?>

            </div>
        </div>
    </section>

    <section id="second-section">
        <h3>MOVIES</h3>
        <div class="movies-card-container">
            <?php 
                $result = get_film_for_home($conn);
                
                while ($row = mysqli_fetch_assoc($result)) {

            ?>

            <div class="movies-card">
                <a href="film_detail.php?id=<?php echo $row['id']?>">
                    <img src="<?php echo $row['image_url'] ?>" alt="film-image">
                </a>

                <div class="movie-info">
                    <a href="film_detail.php?id=<?php echo $row['id']?>"><p class="movie-title"><?php echo $row['title']?></p></a>
                    <p class="movie-genre"><?php echo cleaning_genre($row) ?></p>
                    <p>⭐ <?php echo $row['vote_average'] ?></p>
                </div>
            </div>

            <?php } ?>
        </div>
    </section>

    <footer id="footer">
        <div class="footer-container">

            <div class="footer-left">
                <h3>Navigation</h3>
                <p><a href="#main">Home</a></p>
                <p><a href="#second-section">Movies</a></p>
                <p><a href="#main">Genre</a></p>
            </div>

            <div class="footer-mid">
                <a href="#main"><img src="assets/image/logo-remove-bg.png" width="180px" alt="Film-Holic"></a>
                <h2>Movies Holic</h2>
                <p class="no-click">Film Listing & More</p>
                <p class="movies-holic-tag">© 2026 Movies Holic</p>
            </div>

            <div class="footer-right">
                <h3>Follow Us</h3>
                <p><a href="https://github.com/edwardedo03/Web-Rekomendasi-Film.git">GitHub</a></p>
                <p><a href="">Instagram</a></p>
            </div>
        </div>
    </footer>


</body>
</html>