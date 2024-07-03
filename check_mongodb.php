<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

use MongoDB\Client;

try {
    // Connect to MongoDB
    $client = new Client("mongodb+srv://narbdr81:azIkUTNUWSYgnzMj@cluster0.ndr8aa9.mongodb.net/");

    // List databases to verify the connection
    $databases = $client->listDatabases();

    echo "Connected successfully. Databases:<br>";
    foreach ($databases as $database) {
        echo $database['name'] . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
