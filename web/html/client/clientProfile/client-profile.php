<?php


// Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php'; // pour le menu du header



// Vérification de l'authentification de l'utilisateur

SessionService::system('client', '/back/reservations');
$isAuthenticated = SessionService::isClientAuthenticated();



require_once '../../../models/Client.php';
require_once '../../../models/Image.php';
require_once '../../../models/Gender.php';
require_once '../../../models/Address.php';
require_once '../../../services/ClientService.php';
$client = ClientService::GetClientById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="/client/clientProfile/client-profile.css">

</head>

<body>

    <?php
    require_once("../../components/Header/header.php");
    Header::render(true,false, $isAuthenticated);
    ?>
    <div class="content">
        <div class="content__selector">
            <div class="content__selector__personnal-data">
                <h4 class="content__selector__personnal-data__title">Informations Personnelles</h4>
            </div>
            <div class="content__selector__security">
                <h4 class="content__selector__security__title">Sécurite</h4>
            </div>
        </div>
        <div class="content__personnal-data">
            <h3 class="content__personnal-data__title">Informations Personnelles</h3>
            <p class="content__personnal-data__description">Modifier vos informations Personnelles</p>

            <img class="content__personnal-data__image" src="<?= $client->getImage()->getImageSrc() ?>"
                alt="photo_de_profile">

            <form>
                <div class="content__personnal-data__elements">

                    <!-- Nom -->
                    <?php require_once("../../components/Input/Input.php");
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Nom", "le name", "Nom", true, $client->getLastname()); ?>

                    <!-- Prenom -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Prenom", "le name", "Prenom", true, $client->getFirstname()); ?>

                    <!-- Pseudo -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Pseudo", "le name", "Pseudo", true, $client->getNickname()); ?>

                    <!-- Mail -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "email", "Mail", "le name", "Mail", true, $client->getMail()); ?>

                    <!-- Telephone -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "tel", "Telephone", "le name", "Telephone", true, $client->getPhoneNumber()); ?>

                    <!-- Adresse -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Adresse", "le name", "Adresse", true, $client->getAddress()->getPostalAddress()); ?>

                    <!-- Genre -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Genre", "le name", "Genre", true, $client->getGender()->getLabel()); ?>

                    <!-- Date d'anniversaire -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "Date d'anniversaire", "le name", "Date D'anniversaire", false, $client->getBirthDate()->format('Y-m-d')); ?>

                    <!-- Date de création du compte -->
                    <?php
                    Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "Date de création du compte", "le name", "Date de création du compte", true, $client->getCreationDate()->format('Y-m-d')); ?>
                </div>
            </form>
        </div>
        <div class="content__security" style="display: none">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>

            <div class="content__security__elements">

                <?php
                Input::render("content__security__elements__password", "UnIdEnPlus", "password", "Mot de passe", "le name", "Mot de passe", true); ?>


                <?php require_once("../components/Button/Button.php");
                Button::render("button--storybook", "unId", "Désactiver mon compte", ButtonType::Delete, true); ?>

                <?php
                Button::render("button--storybook", "unId", "Supprimer mon compte", ButtonType::Delete, true); ?>

            </div>
        </div>
    </div>

    <?php
    require_once("../components/Footer/footer.php");
    Footer::render();
    ?>
    <script src="/client/client-profile.js"></script>

</body>

</html>
