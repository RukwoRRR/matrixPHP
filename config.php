<?php

function getDbConnection() {
    $connection = new mysqli('localhost', 'root', 'root', 'matrix');
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}

