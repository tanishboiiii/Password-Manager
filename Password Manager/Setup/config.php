<?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_NAME', 'IPT');
    
    $pdo = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if($pdo === false)
    {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>
