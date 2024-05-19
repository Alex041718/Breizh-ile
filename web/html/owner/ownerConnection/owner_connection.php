<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Compte Propriétaire</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="owner_connection.css">
</head>
<body>

    <div class="connectionContainer">
        <img src="../../assets/images/logo_breizh_noir.png">
        <div class="connectionContainer__box">
            <h3 class="connectionContainer__box__title">Connecter vous à votre compte propriétaire</h3>
            <form action="/controllers/owner/ownerConnectionController.php" method="post">

                <?php require_once("../../components/Input/Input.php"); ?>

                <?= (isset($_SESSION["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_SESSION["redirect"] . "'>" : "") ?>

                <?php Input::render("connection__input", "username", "text", "Identifiant", "username", "Entrez votre identifiant", true); ?>

                <?php Input::render("connection__input", "password", "password", "Mot de Passe", "password", "Entrez votre mot de passe", true); ?>

                <a href="">J'ai oublier mon mot de passe</a>

                <input type="hidden" name="role" value="owner">

                <?php require_once("../../components/Button/Button.php"); ?>


                <?php Button::render("connection__button", "connectButton", "Se connecter",ButtonType::Owner,false,false,true); ?>

            </form>
    </div>
</body>
</html>
