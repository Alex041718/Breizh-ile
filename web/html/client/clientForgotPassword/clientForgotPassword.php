<?php
require_once("../../components/Input/Input.php");
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mot de passe oublié</title>
</head>
<body>
<h1>Mot de passe oublié</h1>
<form method="post" action="/client/clientForgotPassword/sendPasswordReset.php">
    <?php
    Input::render("mail", "mail-du-malheureux", "email", "E-mail", "mail", "Entrez votre email", true);
    ?>
    <button type="submit">Envoyer</button>
</form>
</body>
</html>
