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
    <title>Hackers poulette</title>
</head>
<body>
    <h1>Hackers Poulette SAV</h1>
    <h2>Pour toute difficultée rencontrée, merci de nous contacter via le formulaire suivant !</h2>
    <?php
    require_once '../utils/recaptcha/autoload.php';

    if (isset ($_POST['submit'])) {
        $recaptcha = new ReCaptcha\ReCaptcha('6Lc0SsIqAAAAAAqL8D5hHNpj3gDA9-RFA0uFDJcU');

        $gRecaptchaResponse = $_POST['g-recaptcha-response'];

        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $resp = $recaptcha->setExpectedHostname('localhost')
            ->verify($gRecaptchaResponse, $remoteIp);
        if ($resp->isSuccess()) {
            echo 'Success';
        } else {
            $errors = $resp->getErrorCodes();
            var_dump($errors);
        }
    }

    ?>

    <form method="POST" action="">
        <div>
            <label for="name">Nom :</label>
            <input id="name" name="name" type="text" placeholder="John" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        </div>

        <div>
            <label for="firstname">Prénom :</label>
            <input id="firstname" name="firstname" type="text" placeholder="Doe" value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>" required>
        </div>

        <div>
            <label for="email">Email :</label>
            <input id="email" name="email" type="text" placeholder="johndoe@gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($emailError)): ?>
                <p style="color: red; padding-left: 6px; padding-top: 5px;"><?= htmlspecialchars($emailError) ?></p>
            <?php endif; ?>
        </div>

        <div class="description">
            <label for="description">Description :</label>
            <textarea id="description" name="description" placeholder="Décrivez votre problème..." required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="import">
            <label for="file">Importez votre fichier (Optionnel) :</label>
            <input id="file" name="file" type="file">
        </div>

        <div class="g-recaptcha" data-sitekey="6Lc0SsIqAAAAAIIcxx5jmB6lREe3tXhLIOVE2Get"></div>
        <br/>

        <input type="submit" name="submit" value="Envoyer">
        <?php
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $firstname = $_POST['firstname'];
                $email = $_POST['email'];
                $description = $_POST['description'];
                $file = $_POST['file'];

                $query = $connexion->prepare("INSERT INTO Ticket (name, firstname, email, file, description) VALUES(:name, :firstname, :email, :file, :description)");
                $query->execute([
                    'name' => $name,
                    'firstname' => $firstname,
                    'email' => $email,
                    'file' => $file,
                    'description' => $description
                ]);

                header("Location: http://localhost:8888/Hackers-Poulette/HackersPoulette/pages/success.php");
                exit();
            }
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
        ?>
    </form>
</body>
</html>



