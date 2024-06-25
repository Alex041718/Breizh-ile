<?php
require_once ('../../../services/OwnerService.php');
require_once("../../components/Input/Input.php");
require_once("../../components/Button/Button.php");

$owner = isset($_COOKIE['accountOwner']) ? unserialize( base64_decode( $_COOKIE['accountOwner'])) : false;

$isValid = $owner ? true : false;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Compte Propriétaire</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/owner/ownerRegister/owner_register.css">
    <script src="/owner/ownerRegister/owner_register.js"></script>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LfAbv8pAAAAAHEpM2ncSmnkR1Vw91T_9wMU0dRI"></script>
</head>
<body>
    
    <div class="connectionContainer connectionContainer--register">
        <div class="connectionContainer__box">
            <a href="/">
                <img src="../../assets/images/logo_breizh_noir.png">
            </a>
            <h3 class="connectionContainer__box__title">Création de votre compte propriétaire</h3>
            <?= isset($_GET["error"]) && $_GET["error"] != "" ? '<p class="error">' . $_GET["error"] . '</p>' : "" ?>

            <?php

                if($isValid) {
                    echo '<form method="post" action="/owner/ownerRegister/createAccount.php" class="form__success" id="page0">
                    <p>Un mail contenant un code de vérification vous a été envoyé. Veuillez le saisir dans le champ ci-dessous.</p>';
                    Input::render("connection__input", "code", "number", null, "inputCode", "Code", true);
                    Button::render("connection__button", "submitBtn", "Valider",ButtonType::Owner,false,false,true);
                    echo '</form>' ;
                }
                else if(isset($_GET["success"]) && $_GET["success"] === "true") {
                    echo '<p>Votre compte à été créer avec succès.</p>';
                    Button::render("connection__button","id","Se connecter",ButtonType::Owner,"window.location.href = '/back/connection'",false);
                }

            ?>

            <form data-success="<?= isset($_GET["success"]) && $_GET["success"] !== "" ? $_GET["success"] : "" ?>" id="inscription" enctype="multipart/form-data" action="/owner/ownerRegister/sendAccountCreation.php" method="post">
                
                
                <?php 
                if(!$isValid && !isset($_GET["success"])) { 
                
                    echo '<div class="form__section" id="page1">

                        <input type="hidden" name="addressID" value="0" ?>
                        <div class="connection__input__genders">
                            <label class="input__label para--18px" for="gender">Genre <span class="require">*</span></label>
                            <div class="connection__input__genders-container">';
                                Input::render("connection__input__gender", "male", "radio", "Homme", "genderID", null, false, "1");
                                Input::render("connection__input__gender", "female", "radio", "Femme", "genderID", null, false, "0");
                                Input::render("connection__input__gender", "other", "radio", "Autre", "genderID", null, false, "2");
                            echo '</div>
                        </div>

                        <div class="connectionContainer__box__line">';
                            Input::render("connection__input", "lastName", "text", "Nom", "lastname", "Nom", true);
                            Input::render("connection__input", "firstName", "text", "Prénom", "firstname", "Prénom", true);
                        echo '</div>';

                        Input::render("connection__input", "nickname", "text", "Nom d'utilisateur", "nickname", "Nom d'utilisateur", true);

                    echo '</div>

                    <div class="form__section" id="page2">';
                        Input::render("connection__input", "email", "email", "Adresse email", "mail", "Entrez votre adresse email", true);
                        echo '<div class="connectionContainer__box__line">';
                            Input::render("connection__input", "birthdate", "date", "Date de naissance", "birthDate", "Nom", true);
                            Input::render("connection__input", "phone", "tel", "Téléphone", "phoneNumber", "Numéro de téléphone", true);
                        echo '</div>
                            <div class="connectionContainer__box__line">';
                            Input::render("connection__input", "IDCardFront", "file", "Carte d'identité Recto", "identityCardFront", null, true);
                            Input::render("connection__input", "IDCardBack", "file", "Carte d'identité Verso", "identityCardBack", null, true);
                        echo '</div>';
                        
                    echo '</div>

                    <div class="form__section" id="page4">';
                        Input::render("connection__input", "password", "password", "Mot de passe", "password", "Entrez votre mot de passe", true);
                        Input::render("connection__input confirm__input", "confirm", "password", null, "confirm", "Confirmer votre mot de passe", true);
                        Input::render("consent__input", "confirm", "checkbox", "Je consens à ce que mes données soient collectées et stockées pour le bon fonctionnement du site.", "consent", "", true);
                    echo '</div>' ;

                    echo '<div class="form__section" id="page3">';
                        Input::render("connection__input", "password", "text", "RIB", "bankDetails", "Entrez votre RIB", true);
                        Input::render("connection__input confirm__input", "confirm", "text", "IBAN", "IBAN", "Entrez votre IBAN", true);
                        Input::render("connection__input confirm__input", "confirm", "text", "BIC", "swiftCode", "Entrez votre BIC", true);
                    echo '</div>' ;

                    echo '<div class="connectionContainer__box__line">';
                        Button::render("previous__button", "previousBtn", "Précédent",ButtonType::class,false,false,false);
                        Button::render("next__button", "nextBtn", "Suivant",ButtonType::class,false,false,false);
                    echo '</div>';

                    Button::render("connection__button", "submitBtn", "S'inscrire",ButtonType::Owner,false,false,true);
                } ?>

                <input type="hidden" name="role" value="client">

            </form>
            <script>
                function onClick(e) {
                    e.preventDefault();
                    grecaptcha.enterprise.ready(async () => {
                    const token = await grecaptcha.enterprise.execute('6LfAbv8pAAAAAHEpM2ncSmnkR1Vw91T_9wMU0dRI', {action: 'LOGIN'});
                    });
                }
            </script>
            <?= !$isValid && !isset($_GET["success"]) ?
            '<div class="inscription">
                <div class="horizontal-line"></div>
                <p>OU</p>
                <div class="horizontal-line"></div>
            </div>
            <p class="para--18px">Déjà client ? <a href="/back/connection">Se connecter</a> </p>' : "" ?>

            
    </div>
</body>
</html>
