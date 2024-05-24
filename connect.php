<?php
    // Database connection details
    $host = "localhost";
    $username = "root";
    $password = "root";
    $database = "orgdb";

    // Create a database connection
    $mysqli = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($mysqli -> connect_error) {
        die("Connection failed: " . $mysqli -> connect_error);
    }
?>