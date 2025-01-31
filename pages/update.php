<?php

include('../utils/database-config.php');
global $connexion;

function mailIsValid($mail) {
    $validMail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    return preg_match($validMail, $mail) === 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailError = '';

    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        if (!mailIsValid($email)) {
            $emailError = "Veuillez entrer un format d'adresse email valide.";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {

        $query = $connexion->prepare('SELECT * FROM Ticket WHERE id = :id');
        $query->execute(['id' => $id]);
        $ticket = $query->fetch();

    } catch (PDOException $error) {
        die($error->getMessage());
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../styles/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Update Ticket</title>
</head>
<body>
    <h1>Modifier le ticket</h1>

    <form method="POST" action="">
        <div>
            <label for="name">Nom :</label>
            <input id="name" name="name" type="text" placeholder="John" value="<?=($ticket['name']) ?>" required>
        </div>

        <div>
            <label for="firstname">Prénom :</label>
            <input id="firstname" name="firstname" type="text" placeholder="Doe" value="<?=($ticket['firstname']) ?>" required>
        </div>

        <div>
            <label for="email">Email :</label>
            <input id="email" name="email" type="text" placeholder="johndoe@gmail.com" value="<?=($ticket['email']) ?>" required>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($emailError)): ?>
                <p style="color: red; padding-left: 6px; padding-top: 5px;"><?= htmlspecialchars($emailError) ?></p>
            <?php endif; ?>
        </div>

        <div class="description">
            <label for="description">Description :</label>
            <input type="text" id="description" name="description" value="<?=($ticket['description']) ?>" required>
        </div>

        <div class="import">
            <label for="file">Importez votre fichier (Optionnel) :</label>
            <input id="file" name="file" type="file">
        </div>

        <div class="status">
            <?php
                $ticketStatus = $ticket['status'];
            ?>
            <h4>Status :</h4>
            <label for="status"></label>
            <select name="status" id="status">
                <option value="Pending" <?= $ticketStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="In progress" <?= $ticketStatus === 'In progress' ? 'selected' : '' ?>>In progress</option>
                <option value="Done" <?= $ticketStatus === 'Done' ? 'selected' : '' ?>>Done</option>
            </select>
        </div>

        <input type="submit" name="submit" value="Envoyer">
        <?php
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $email = $_POST['email'];
                $description = $_POST['description'];
                $file = $_POST['file'];
                $status = $_POST['status'];

                $query = $connexion->prepare("UPDATE Ticket SET name=:name, firstname=:firstname, email=:email, file=:file, description=:description, status=:status WHERE id=:id");
                $query->execute([
                    ':name' => $name,
                    ':firstname' => $firstname,
                    ':email' => $email,
                    ':file' => $file,
                    ':description' => $description,
                    ':status' => $status,
                    ':id' => $id
                ]);

                header("Location: http://localhost:80/hackers-poulette/pages/dashboard.php");
                exit();
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
        ?>
    </form>
</body>
</html>



