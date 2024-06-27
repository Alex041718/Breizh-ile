<?php session_start(); 

require_once '../../../services/SessionService.php'; // pour le menu du header
$isAuthenticated = SessionService::isOwnerAuthenticated();

if($isAuthenticated) {
    header("Location: /back/logements");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Compte Propriétaire</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/ownerConnection/owner_connection.css">
    <link rel="stylesheet" href="/components/Button/Button.css">
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfAbv8pAAAAAHEpM2ncSmnkR1Vw91T_9wMU0dRI"></script>
</head>
<body>

    <div class="connectionContainer">
        <div class="connectionContainer__box">
            <a href="/">
                <img src="../../assets/images/logo_breizh_noir.png">
            </a>
            <h3 class="connectionContainer__box__title">Connectez vous à votre compte propriétaire</h3>
            <form action="/controllers/owner/ownerConnectionController.php" method="post">

                <?php require_once("../../components/Input/Input.php"); ?>

                <?= isset($_GET["error"]) && $_GET["error"] == "loginFailed" ? '<p class="error">Identifiants incorrects</p>' : "" ?>


                <?= (isset($_GET["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_GET["redirect"] . "'>" : "<input type='hidden' name='redirect' value='" . "/back/reservations" . "'>") ?>


                <?php Input::render("connection__input", "mail", "text", "E-mail", "mail", "Entrez votre e-mail", true); ?>

                <?php Input::render("connection__input", "password", "password", "Mot de Passe", "password", "Entrez votre mot de passe", true); ?>

                <a href="/back/forgot-password" class="connectionContainer__box__forgot">J'ai oublié mon mot de passe</a>

                <input type="hidden" name="role" value="owner">

                <?php require_once("../../components/Button/Button.php"); ?>


                <button type="submit" id="connectButton" class="button button--owner button--bleu connection__button g-recaptcha" 
                        data-sitekey="reCAPTCHA_site_key" 
                        data-callback="onSubmit"
                        data-action="submit">Se connecter
                </button>

            </form>

            <div class="inscription">
                <div class="horizontal-line"></div>
                <p class="para--20px">OU</p>
                <div class="horizontal-line"></div>
            </div>
            <p class="para--18px">Pas encore de compte ? <a href="/back/register">S'inscrire</a> </p>
    </div>
    <script>
        function onClick(e) {
            e.preventDefault();
            grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute('6LfAbv8pAAAAAHEpM2ncSmnkR1Vw91T_9wMU0dRI', {action: 'LOGIN'});
            });
        }
    </script>
</body>
</html>
