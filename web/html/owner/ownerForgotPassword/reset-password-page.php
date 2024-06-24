<?php
require_once("../../../services/OwnerService.php");
require_once("../../components/Input/Input.php");

if(!isset($_GET["token"])) {
    header("Location: /");
    return;
}

$token = $_GET["token"];

$user = OwnerService::GetOwnerByToken($token);

date_default_timezone_set('Europe/Paris');
$time = time();
//Check si on a récupéré un utilisateur
if ($user == null) {
    header("Location: /");
}
if (($user->getResetTokenExpiration()->getTimestamp()) < $time) {
    header("Location: /");
}

//echo "Token valide";
?>

<?php

require_once("../../components/Input/Input.php");
require_once("../../components/Button/Button.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du mot de passe</title>
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
            
            
            <?php 
            if(isset($_GET["success"]) && $_GET["success"] == "true") {
                echo "<p>Votre mot de passe a été modifié avec succès !</p>";
                Button::render("connection__button","id","Se connecter",ButtonType::Owner,"window.location.href = '/back/connection'",false);
            }
            else {
                echo isset($_GET["error"]) && $_GET["error"] != "" ? '<p class="error">' . $_GET["error"] . '</p>' : "";
                echo '<form method="post" action="/owner/ownerForgotPassword/reset-password-action.php">
                    <input type="hidden" name="clientId" value="' . $user->getOwnerID() . '">
                    <input type="hidden" name="token" value="'. $token . '">';
                    Input::render("connection__input","password","password","Nouveau mot de passe","firstPasswordEntry","",true);
                    Input::render("connection__input","password","password","Confirmer le mot de passe","secondPasswordEntry","",true);
                    Button::render("connection__button", "connectButton", "Sauvegarder",ButtonType::Owner,false,false,true);        
                echo '</form>';
            } ?>
             
    </div>
</body>
</html>
