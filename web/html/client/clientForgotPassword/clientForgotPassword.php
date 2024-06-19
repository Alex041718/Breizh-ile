<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Compte Client</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/client/clientConnection/client_connection.css">
</head>
<body>

    <div class="connectionContainer">
        <div class="connectionContainer__box">
            <a href="/">
                <img src="../../assets/images/logo_breizh_noir.png">
            </a>
            <h3 class="connectionContainer__box__title">Mot de passe oublié</h3>
            <form method="post" action="/client/clientForgotPassword/sendPasswordReset.php">
                <?php
                    require_once("../../components/Input/Input.php");
                    require_once("../../components/Button/Button.php");

                    Input::render("connection__input", "mail-du-malheureux", "email", "E-mail", "mail", "Entrez votre email", true);

                    Button::render("connection__button", "connectButton", "Envoyer",ButtonType::Client,false,false,true);
                ?>
            </form>
            <div class="inscription">
                <div class="horizontal-line"></div>
                <p>OU</p>
                <div class="horizontal-line"></div>
            </div>
            <p class="para--18px">Pas encore de compte ? <a href="/client/register">S'inscrire</a> </p>
            
    </div>
</body>
</html>
