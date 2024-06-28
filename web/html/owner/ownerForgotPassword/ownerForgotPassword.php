<?php

require_once("../../components/Input/Input.php");
require_once("../../components/Button/Button.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/ownerConnection/owner_connection.css">
</head>
<body>

    <div class="connectionContainer">
        <div class="connectionContainer__box">
            <a href="/">
                <img src="../../assets/images/logo_breizh_noir.png">
            </a>
            <h3 class="connectionContainer__box__title">Mot de passe oublié</h3>
            
            <?= isset($_GET["error"]) && $_GET["error"] != "" ? '<p class="error">' . $_GET["error"] . '</p>' : "" ?>

            <?php 


            if(isset($_GET["success"]) && isset($_GET["success"]) == "true") {
                echo "<p>Si vous avez un compte, un mail de réinitialisation vous a été envoyé.</p>";
                Button::render("connection__button","id","Se connecter",ButtonType::Owner,"window.location.href = '/back/connection'",false);
            }
            else { 
                echo '<form method="post" action="/owner/ownerForgotPassword/sendPasswordReset.php">';
                    Input::render("connection__input", "mail-du-malheureux", "email", "E-mail", "mail", "Entrez votre email", true);
                    Button::render("connection__button", "connectButton", "Envoyer",ButtonType::Owner,false,false,true);
                echo '</form>
                <div class="inscription">
                    <div class="horizontal-line"></div>
                    <p>OU</p>
                    <div class="horizontal-line"></div>
                </div>
                <p class="para--18px">Pas encore de compte ? <a href="/owner/register">S\'inscrire</a> </p>';
            } ?>
            
    </div>
</body>
</html>
