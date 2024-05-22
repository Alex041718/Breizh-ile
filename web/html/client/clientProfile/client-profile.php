<?php
// Import des services nécessaires
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php';

// Récupération des genres de la plateforme
require_once '../../../services/GenderService.php';
$genders = GenderService::GetAllGenders();

// Fonction de redirection
function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

// Vérifier l'authentification du client
SessionService::system('client', '/client/profil');
$isAuthenticated = SessionService::isClientAuthenticated();

if (!$isAuthenticated) {
    redirect('/login'); // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
}

// Récupérer le client authentifié
$clientID = $_SESSION['user_id'];
$client = ClientService::GetClientById($clientID);

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
    Header::render(true,false, $isAuthenticated, '/client/profil');
    ?>
    <div class="content">
        <div class="content__selector">
            <div class="content__selector__personnal-data">
                <h4 class="content__selector__personnal-data__title">Informations Personnelles</h4>
            </div>
            <div class="content__selector__security">
                <h4 class="content__selector__security__title">Sécurité</h4>
            </div>
        </div>
        <div class="content__personnal-data">
            <h3 class="content__personnal-data__title">Informations Personnelles</h3>

            <div class="content__personnal-data__top">
                <p class="content__personnal-data__top__description">Modifier vos informations Personnelles</p>

                <img class="content__personnal-data__image" src="<?= $client->getImage()->getImageSrc() ?>"
                    alt="photo_de_profile">
            </div>

            <form method="POST" action="/controllers/client/clientUpdateController.php">
                <div class="content__personnal-data__elements">
                    <!-- Nom -->
                    <?php require_once ("../../components/Input/Input.php");
                    Input::render("uneClassEnPlus", "lastname", "text", "Nom", "lastname", "Nom", true, $client->getLastname()); ?>

                    <!-- Prenom -->
                    <?php
                    Input::render("uneClassEnPlus", "firstname", "text", "Prenom", "firstname", "Prenom", true, $client->getFirstname()); ?>

                    <!-- Pseudo -->
                    <?php
                    Input::render("uneClassEnPlus", "nickname", "text", "Pseudo", "nickname", "Pseudo", true, $client->getNickname()); ?>

                    <!-- Mail -->
                    <?php
                    Input::render("uneClassEnPlus", "mail", "email", "Mail", "mail", "Mail", true, $client->getMail()); ?>

                    <!-- Telephone -->
                    <?php
                    Input::render("uneClassEnPlus", "phoneNumber", "tel", "Telephone", "phoneNumber", "Telephone", true, $client->getPhoneNumber()); ?>

                    <!-- Adresse -->
                    <?php
                    Input::render("uneClassEnPlus", "address", "text", "Adresse", "address", "Adresse", true, $client->getAddress()->getPostalAddress()); ?>

                    <!-- Genre -->
                    <div class="content__personnal-data__elements__genre">
                        <label for="genderID">Genre</label>
                        <select name="genderID" id="genderID" class="content__personnal-data__elements__select">
                            <?php foreach ($genders as $gender): ?>
                                <option <?= $client->getGender()->getGenderID() == $gender->getGenderID() ? "selected" : "" ?>
                                    value="<?= $gender->getGenderID() ?>"><?= $gender->getLabel() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Date de naissance -->
                    <?php
                    Input::render("uneClassEnPlus", "birthDate", "date", "Date de naissance", "birthDate", "Date de naissance", false, $client->getBirthDate()->format('Y-m-d')); ?>

                    <!-- Date de création du compte -->
                    <?php
                    Input::render("uneClassEnPlus", "creationDate", "date", "Date de création du compte", "creationDate", "Date de création du compte", true, $client->getCreationDate()->format('Y-m-d')); ?>

                    <input type="hidden" name="clientID" value="<?php echo ($client->getClientID()) ?>">

                </div>
                <!-- Confirmer modifications button -->
                <div class="content__personnal-data__elements__modify_button">
                    <?php
                    require_once ("../../components/Button/Button.php");
                    Button::render("button--storybook", "modifier", "Valider les modifications", ButtonType::Client, "", true, true); ?>
                </div>
            </form>
        </div>
        <div class="content__security" style="display: none">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>

            <div class="content__security__elements">
                <?php
                Input::render("content__security__elements__password", "password", "password", "Modifier Mot de passe", "password", "Mot de passe", true); ?>
            </div>
            <div class="content__security__moderator">
                <?php
                Button::render("button--storybook", "deactivate-account", "Désactiver mon compte", ButtonType::Delete, true); ?>

                <?php
                Button::render("button--storybook", "delete-account", "Supprimer mon compte", ButtonType::Delete, true); ?>
            </div>
        </div>
    </div>

    <?php
    require_once ("../../components/Footer/footer.php");
    Footer::render();
    ?>
    <script src="/client/clientProfile/client-profile.js"></script>
</body>

</html>