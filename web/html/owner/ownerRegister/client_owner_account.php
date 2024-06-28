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
            
            <h3 class="connectionContainer__box__title">Création de votre compte client</h3>
            <p class="error"><?= $_GET["error"] ?></p>
            <form action="/client/clientRegister/sendAccountCreation.php" method="post">

                <?php require_once("../../components/Input/Input.php"); ?>

                <?= (isset($_GET["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_GET["redirect"] . "'>" : "<input type='hidden' name='redirect' value='" . "/back" . "'>") ?>

                <div class="connectionContainer__box__line">
                    <?php Input::render("connection__input", "lastName", "text", "Nom", "mail", "Nom", true); ?>
                    <?php Input::render("connection__input", "lastName", "text", "Prénom", "mail", "Prénom", true); ?>
                </div>

                <?php Input::render("connection__input", "birthdate", "date", "Date de naissance", "mail", "Nom", true); ?>

                <?php Input::render("connection__input", "password", "password", "Mot de passe", "mail", "Entrez votre mot de passe", true); ?>
                <?php Input::render("connection__input", "confirm", "password", null, "mail", "Confirmer votre mot de passe", false); ?>


                <input type="hidden" name="role" value="client">

                <?php require_once("../../components/Button/Button.php"); ?>


                <?php Button::render("connection__button", "connectButton", "S'inscrire",ButtonType::Client,false,false,true); ?>

            </form>
        </div>
    </div>
</body>
</html>
