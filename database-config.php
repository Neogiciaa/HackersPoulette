<?php

try {
    $connexion = new PDO('mysql:host=localhost;dbname=hackerspoulette', 'root', 'hahanicetrybitch');
    echo 'Connexion à la base de données réussie';
} catch (PDOException $error) {
    echo $error->getMessage();
}