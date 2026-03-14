<?php
    include("connect_db.php");

    function get_film_for_home($conn) {
        $query = mysqli_query($conn, "SELECT * FROM top_10000_movies LIMIT 54");
        
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
</head>
<body>
    <div class="side-nav-button">
        <label class="side-nav-button">☰</label>
    </div>

    <div class="side-navbar">
        <ul>
            <li><a href="#main">Home</a></li>
            <li><a href="#main">Genre</a></li>
        </ul>
    </div>

    <nav id="nav">
        <div></div>
        
        <div class="image-logo">
            <a href="index.php"><img src="assets/image/logo-remove-bg.png" width="180px" alt="Film-Holic"></a>
        </div>

        <div class="image-search">
            <img src="assets/icon/search.png" alt="search-logo">
        </div>
    </nav>

    <section id="main">
        <h3>TOP MOVIES</h3>
        <div class="marquee-main-container">
            <!-- nanti tambahin code php supaya otomatis muncul, ga satu satu nambahin foto-->
            <div class="marquee">

                <?php
                    $result = get_film_for_recommendation($conn);

                    while($row = mysqli_fetch_assoc($result)) { 

                ?>
                
                <a href="">
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
                <a href="">
                    <img src="<?php echo $row['image_url'] ?>" alt="film-image">
                </a>
                <div class="movie-info">
                    <a href=""><p class="movie-title"><?php echo $row['title']?></p></a>
                    <p class="movie-genre"><?php echo cleaning_genre($row) ?></p>
                    <p>⭐ <?php echo $row['vote_average'] ?></p>
                </div>
            </div>

            <?php } ?>
        </div>
    </section>

</body>
</html>