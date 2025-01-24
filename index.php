<?php

include('database-config.php');
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

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="form.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Hackers poulette</title>
</head>
<body>
    <h1>Hackers Poulette SAV</h1>
    <h2>Pour toute difficultée rencontrée, merci de nous contacter via le formulaire suivant !</h2>

    <form method="POST" action="">
        <div>
            <label for="name">Nom :</label>
            <input id="name" name="name" type="text" placeholder="John" required>
        </div>

        <div>
            <label for="firstname">Prénom :</label>
            <input id="firstname" name="firstname" type="text" placeholder="Doe" required>
        </div>

        <div>
            <label for="email">Email :</label>
            <input id="email" name="email" type="text" placeholder="johndoe@gmail.com" required>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($emailError)): ?>
                <p><?= htmlspecialchars($emailError) ?></p>
            <?php endif; ?>
        </div>

        <div class="description">
            <label for="description">Description :</label>
            <textarea id="description" name="description" placeholder="Décrivez votre problème..." required></textarea>
        </div>

        <div class ="import">
            <label for="file">Importez votre fichier :</label>
            <input id="file" name="file" type="file">
        </div>

        <input type="submit" value="Envoyer">
    </form>
</body>
</html>



