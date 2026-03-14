<?php
include("connect_db.php");

$api_key = "996a5900ee3e5d280817e67541613815"; 

// Ambil 10 data dulu buat ngetes (biar cepet)
$query = mysqli_query($conn, "SELECT title FROM top_10000_movies WHERE image_url = '' OR image_url IS NULL LIMIT 30");

if (mysqli_num_rows($query) == 0) {
    die("Semua data sudah punya gambar!");
}

while ($row = mysqli_fetch_assoc($query)) {
    $title = $row['title'];
    $url = "https://api.themoviedb.org/3/search/movie?api_key=" . $api_key . "&query=" . urlencode($title);
    
    // Pakai cURL (Lebih kuat dari file_get_contents)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bypass error SSL di localhost
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo "❌ Error Koneksi: " . $err . "<br>";
    } else {
        $data = json_decode($response, true);
        
        if (!empty($data['results'][0]['poster_path'])) {
            $poster_path = $data['results'][0]['poster_path'];
            $full_url = "https://image.tmdb.org/t/p/w500" . $poster_path;
            $safe_title = mysqli_real_escape_string($conn, $title);
            
            mysqli_query($conn, "UPDATE top_10000_movies SET image_url = '$full_url' WHERE title = '$safe_title'");
            echo "✅ Berhasil update: <b>$title</b> <br>";
        } else {
            echo "❓ Tidak ketemu: $title <br>";
        }
    }
    usleep(100000); 
}
echo "<br> Selesai! Cek database atau halaman utama sekarang.";
?>