<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Compte Client</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/client/clientRegister/client_register.css">
</head>
<body>

    <div class="connectionContainer">
        <div class="connectionContainer__box">
            <a href="/">
                <img src="../../assets/images/logo_breizh_noir.png">
            </a>
            <h3 class="connectionContainer__box__title">Création de votre compte client</h3>
            <form action="/client/clientRegister/sendAccountCreation.php" method="post">

                <?php require_once("../../components/Input/Input.php"); ?>

                <?= (isset($_GET["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_GET["redirect"] . "'>" : "<input type='hidden' name='redirect' value='" . "/back" . "'>") ?>

                <?php Input::render("connection__input", "mail", "text", "E-mail", "mail", "Entrez votre e-mail", true); ?>



                <input type="hidden" name="role" value="client">

                <?php require_once("../../components/Button/Button.php"); ?>


                <?php Button::render("connection__button", "connectButton", "S'inscrire",ButtonType::Client,false,false,true); ?>

            </form>
            <div class="inscription">
                <div class="horizontal-line"></div>
                <p>OU</p>
                <div class="horizontal-line"></div>
            </div>
            <p class="para--18px">Déjà client ? <a href="/client/connection">Se connecter</a> </p>

            
    </div>
</body>
</html>
