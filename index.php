<?php

include('database-config.php');
global $connexion;

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="form.css">
    <title>Hackers poulette</title>
</head>
<body>
    <form>
        <label for="name">Nom :</label>
        <input id="name" type="text" placeholder="John">

        <label for="firstname">Prénom :</label>
        <input id="firstname" type="text" placeholder="Doe">

        <label for="email">Nom :</label>
        <input id="email" type="text" placeholder="johndoe@gmail.com">

        <label for="file">Importez votre fichier :</label>
        <input id="file" type="file">

        <label for="description">Description :</label>
        <input id="description" type="text" placeholder="Blabla">
    </form>
</body>
</html>



