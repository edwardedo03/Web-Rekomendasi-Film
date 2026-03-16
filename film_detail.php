<?php
    include("connect_db.php");

    $id = $_GET["id"];

    $query = mysqli_query($conn, "SELECT * FROM top_10000_movies WHERE id = $id");

    $film = mysqli_fetch_array($query);

    function footer_recommendation($conn) {
        $query = mysqli_query($conn, "SELECT * FROM top_10000_movies ORDER BY RAND() LIMIT 6");
        
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
        <title><?php echo $film['title']?></title>
        <link rel="stylesheet" href="film_detail_style.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="side-navbar">
            <label class="side-nav-button">☰</label>
            <ul class="side-navbar-ul">
                <li><a href="index.php">Home</a></li>
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

        <div class="main-container">
            <div class="image-box">
                <img src="<?php echo $film['image_url'] ?>" alt="">
            </div>

            <div class="info-box">
                <h1><?php echo $film['title'] ?></h1>
                <p><?php echo cleaning_genre($film) ?></p>
                <p>⭐ <?php echo $film['vote_average'] ?></p>
                <p><?php echo $film['release_date'] ?></p>
                <p class="film-overview"><?php echo $film['overview'] ?></p>
            </div>
        </div>

        <div class="recommendation-film">
            <h3>ANOTHER MOVIES</h3>
            <div class="film-container">
                <?php
                    $result = footer_recommendation($conn);

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
    </body>
    </html>