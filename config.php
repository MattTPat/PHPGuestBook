<?php

// Database credentials.
define('DB_HOST', 'localhost');
define('DB_NAME', 'assignment1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_TABLENAME', 'login');

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);


// Check connection
if($mysqli === false){
    echo 'NOPE';
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

?>