<?php

include('../utils/database-config.php');
global $connexion;

$query = $connexion->prepare("SELECT * FROM Ticket WHERE (:id is null or id = :id) AND (:status = 'all' or status = :status)");
$searchById = !empty($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
$searchByStatus = $_POST['filter'] ?? 'all';
$query->bindParam(':id', $searchById);
$query->bindParam(':status', $searchByStatus);
$query->execute();
$result = $query->fetchAll();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<section class="dashboard-container">
    <nav class="dashboard-menu">
        <ul>
            <li><a href="dashboard.php">Accueil</a></li>
            <li><a href="dashboard.php">Calendrier</a></li>
            <li><a href="dashboard.php">Réunions</a></li>
            <li><a href="dashboard.php">Équipes</a></li>
            <li><a href="index.php">Nouveau Ticket</a></li>
            <li><a href="dashboard.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="dashboard-interface">
        <h1>Dashboard Hackers Poulette &copy</h1>
        <h2>Liste des Tickets</h2>
        <form method="POST" action="">
            <label for="ticket_id">
                <input type="text" name="ticket_id" placeholder="Rechercher par ID de ticket"
                       value="<?= htmlspecialchars(!empty($_POST['ticket_id']) ? $_POST['ticket_id'] : '') ?>">
            </label>
            <input type="submit" name="search" value="Rechercher">
            <div class="filter-container">
                    <label for="filter">Filtrer par status :</label>
                    <div class="filter-dropdown">
                        <select name="filter" id="filter">
                            <option value="all" <?= $searchByStatus === 'all' ? 'selected' : '' ?>>All</option>
                            <option value="Pending" <?= $searchByStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="In progress" <?= $searchByStatus === 'In progress' ? 'selected' : '' ?>>In progress</option>
                            <option value="Done" <?= $searchByStatus === 'Done' ? 'selected' : '' ?>>Done</option>
                        </select>
                        <button type="submit">Filtrer</button>
                    </div>
                </div>
        </form>

        <div class="ticket-list">
            <table>
                <thead>
                <tr>
                    <th>Ticket N°</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result as $ticket): ?>
                    <tr>
                        <td><?= htmlspecialchars($ticket['id']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $ticket['id'] ?>">
                                <?= htmlspecialchars($ticket['description']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($ticket['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
</body>
</html>
