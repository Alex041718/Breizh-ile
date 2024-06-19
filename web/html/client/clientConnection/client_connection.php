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
            <h3 class="connectionContainer__box__title">Connectez vous à votre compte client</h3>
            <form action="/controllers/client/clientConnectionController.php" method="post">

                <?php require_once("../../components/Input/Input.php"); ?>

                <?= (isset($_GET["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_GET["redirect"] . "'>" : "<input type='hidden' name='redirect' value='" . "/back" . "'>") ?>

                <?php Input::render("connection__input", "mail", "text", "E-mail", "mail", "Entrez votre e-mail", true); ?>

                <?php Input::render("connection__input", "password", "password", "Mot de Passe", "password", "Entrez votre mot de passe", true); ?>

                <a href="/client/clientForgotPassword/clientForgotPassword.php" class="connectionContainer__box__forgot">J'ai oublié mon mot de passe</a>

                <input type="hidden" name="role" value="client">

                <?php require_once("../../components/Button/Button.php"); ?>


                <?php Button::render("connection__button", "connectButton", "Se connecter",ButtonType::Client,false,false,true); ?>

            </form>
            <div class="inscription">
                <div class="horizontal-line"></div>
                <p>OU</p>
                <div class="horizontal-line"></div>
            </div>

            <a href="" class="para--20px">S'inscrire</a>
            
    </div>
</body>
</html>
