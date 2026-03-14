<?php
    include("connect_db.php");

    function get_film_for_home($conn) {
        $query = mysqli_query($conn, "SELECT * FROM top_10000_movies LIMIT 50");
        
        if(mysqli_num_rows($query) > 0) {
            return $query;
        } else {
            return "Empty";
        }        
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
    <nav id="nav">
        <div class="image-nav">
            <a href="index.php"><img src="assets/image/logo-remove-bg.png" width="150px" alt="Film-Holic"></a>
        </div>

        <div class="menu-nav">
            <ul>
                <li><a href="#main">Home</a></li>
                <li><a href="">Genre</a></li>
                <li><a href="">About</a></li>
            </ul>
        </div>

        <div class="image-nav">
            <img src="assets/icon/search.png" alt="search-logo">
        </div>
    </nav>

    <section id="main">
        <h3>RECOMMENDATION</h3>
        <div class="marquee-main-container">
            <!-- nanti tambahin code php supaya otomatis muncul, ga satu satu nambahin foto-->
            <marquee scrollamount="7" behavior="scroll" direction="left">
                <div class="marquee-items">
                    <img src="https://plus.unsplash.com/premium_photo-1673448391005-d65e815bd026?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Zm90b3xlbnwwfHwwfHx8MA%3D%3D" alt="">
                    <img src="https://plus.unsplash.com/premium_photo-1673448391005-d65e815bd026?fm=jpg&q=60&w=3000&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8Zm90b3xlbnwwfHwwfHx8MA%3D%3D" alt="">
                </div>
            </marquee>
        </div>
    </section>

    <section id="second-section">
        <h3>MOVIES</h3>
        <div class="movies-card-container">
            <?php 
                $result = get_film_for_home($conn);
                
                while ($row = mysqli_fetch_assoc($result)) {

                    $genre_clean = $row['genre'];
                    $items = array('[', ']', "'");
                    $genre_clean = str_replace($items, "", $genre_clean);
                    $genre_clean = str_replace(",", " •", $genre_clean);
            ?>

            <div class="movies-card">
                <a href="">
                    <img src="<?php echo $row['image_url'] ?>" alt="film-image">
                </a>
                <div class="movie-info">
                    <a href=""><p class="movie-title"><?php echo $row['title']?></p></a>
                    <p><?php echo $genre_clean ?></p>
                    <p>⭐ <?php echo $row['vote_average'] ?></p>
                </div>
            </div>

            <?php } ?>

        </div>
    </section>

</body>
</html>