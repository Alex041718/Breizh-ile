<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Compte Propriétaire</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/ownerConnection/owner_connection.css">
</head>
<body>

    <div class="connectionContainer">
        <div class="connectionContainer__box">
            <img src="../../assets/images/logo_breizh_noir.png">
            <h3 class="connectionContainer__box__title">Connectez vous à votre compte propriétaire</h3>
            <form action="/controllers/owner/ownerConnectionController.php" method="post">

                <?php require_once("../../components/Input/Input.php"); ?>

                <?= isset($_GET["error"]) && $_GET["error"] == "loginFailed" ? '<p class="error">Identifiants incorrects</p>' : "" ?>


                <?= (isset($_GET["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_GET["redirect"] . "'>" : "<input type='hidden' name='redirect' value='" . "/back/reservations" . "'>") ?>


                <?php Input::render("connection__input", "mail", "text", "E-mail", "mail", "Entrez votre e-mail", true); ?>

                <?php Input::render("connection__input", "password", "password", "Mot de Passe", "password", "Entrez votre mot de passe", true); ?>

                <a href="" class="connectionContainer__box__forgot">J'ai oublié mon mot de passe</a>

                <input type="hidden" name="role" value="owner">

                <?php require_once("../../components/Button/Button.php"); ?>


                <?php Button::render("connection__button", "connectButton", "Se connecter",ButtonType::Owner,false,false,true); ?>

            </form>

            <div class="inscription">
                <div class="horizontal-line"></div>
                <p class="para--20px">OU</p>
                <div class="horizontal-line"></div>
            </div>
            <p class="para--18px">Pas encore de compte ? <a href="">S'inscrire</a> </p>
    </div>
</body>
</html>
