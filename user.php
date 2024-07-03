<?php
require 'vendor/autoload.php'; 

use MongoDB\Client;

session_start(); 

try {
    $client = new Client("mongodb+srv://narbdr81:azIkUTNUWSYgnzMj@cluster0.ndr8aa9.mongodb.net/");

    $database = $client->test;

    $collection = $database->users;

    $name = $_POST['name'];
    $email = $_POST['email'];

    $existingUser = $collection->findOne(['email' => $email]);

    if ($existingUser) {
        echo "User with email '{$email}' already exists.";
    } else {
        $insertResult = $collection->insertOne([
            'name' => $name,
            'email' => $email,
            'date' => new MongoDB\BSON\UTCDateTime(),
        ]);

        if ($insertResult->getInsertedCount() > 0) {
            $_SESSION['submitted'] = true;

            header("Location: video.php");
            exit; 
        } else {
            echo "Failed to insert data.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>