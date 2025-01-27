<?php

include('../utils/database-config.php');
global $connexion;


try {
    $query = $connexion->prepare("SELECT * FROM Ticket");
    $query->execute();
    $result = $query->fetchAll();
} catch (PDOException $error) {
    echo $error->getMessage();
}


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard Hackers Poulette &copy</h1>

    <section class="dashboard-container">
        <div class="dashboard-menu">
            <ul>
                <li><a href="dashboard.html">Acceuil</a></li>
                <li><a href="dashboard.html">Calendrier</a></li>
                <li><a href="dashboard.html">Réunions</a></li>
                <li><a href="dashboard.html">Equipes</a></li>
                <li><a href="dashboard.html">Logout</a></li>
            </ul>
        </div>

        <div class="dashboard-interface">
            <article>
                <div>
                    <p>N° ticket :</p>
                    <p>Description :</p>
                    <p>Status :</p>
                </div>

            </article>
        </div>
    </section>
</body>
</html>
