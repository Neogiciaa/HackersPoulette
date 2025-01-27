<?php

try {
    $connexion = new PDO('mysql:host=mysql57;dbname=hackerspoulette', 'root', 'rootsosecure');
    echo 'Connexion à la base de données réussie';
} catch (PDOException $error) {
    echo $error->getMessage();
}