<?php

    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "database_film";

    try {
        $conn = mysqli_connect($server, $user, $pass, $db);
    } catch (Exception $e) {
        echo "error {$e}";
    }

?>