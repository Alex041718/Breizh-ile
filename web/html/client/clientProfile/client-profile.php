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
SessionService::system('client', '/client/profile');
$isAuthenticated = SessionService::isClientAuthenticated();

if (!$isAuthenticated) {
    redirect('/login'); // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
}

// Récupérer le client authentifié
$clientID = $_SESSION['user_id'];
$client = ClientService::GetClientById($clientID);
$res = "bite"
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="/client/clientProfile/client-profile.css">
    <link rel="stylesheet" href="/components/Toast/Toast.css">


    <link rel="stylesheet" href="../../style/ui.css">
</head>

<body>
    <?php
    require_once ("../../components/Header/header.php");
    Header::render(true, false, $isAuthenticated, '/client/profile');
    ?>
    <main class="content">
        <nav>
            <ul>
                <li id="infos__btn" class="active">
                    <span>Informations Personnelles</span>
                    <img src="./../../../assets/icons/personal.svg" alt="Personal Info Icon" class="nav-icon">
                </li>
                <li id="security__btn">
                    <span>Sécurité</span>
                    <img src="./../../../assets/icons/settings.svg" alt="Security Icon" class="nav-icon">
                </li>
            </ul>
        </nav>

        <div id="infos" class="content__personnal-data content__display">
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

                    Input::render("uneClassEnPlus", "lastname", "text", "Nom", "lastname", "Nom", true, $client->getLastname(), '1', '100'); ?>

                    <!-- Prenom -->
                    <?php
                    Input::render("uneClassEnPlus", "firstname", "text", "Prenom", "firstname", "Prenom", true, $client->getFirstname(), '1', '100'); ?>

                    <!-- Pseudo -->
                    <?php
                    Input::render("uneClassEnPlus", "nickname", "text", "Pseudo", "nickname", "Pseudo", true, $client->getNickname(), '1', '100'); ?>

                    <!-- Mail -->
                    <?php
                    Input::render("uneClassEnPlus", "mail", "email", "Mail", "mail", "Mail", true, $client->getMail(), '1', '100'); ?>

                    <!-- Telephone -->
                    <?php
                    Input::render("uneClassEnPlus", "phoneNumber", "tel", "Telephone", "phoneNumber", "Telephone", true, $client->getPhoneNumber(), '10', '12'); ?>

                    <!-- Adresse -->
                    <?php
                    Input::render("uneClassEnPlus", "address", "text", "Adresse", "address", "Adresse", true, $client->getAddress()->getPostalAddress(), "1", "200"); ?>

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

                    <input type="hidden" name="creationDate"
                        value="<?php echo ($client->getCreationDate()->format('Y-m-d')) ?>">
                    <input type="hidden" name="clientID" value="<?php echo ($client->getClientID()) ?>">

                </div>
                <!-- Confirmer modifications button -->
                <div class="content__personnal-data__elements__modify_button">
                    <?php
                    require_once ("../../components/Button/Button.php");

                    Button::render("button--storybook", "modifier", "Valider les modifications", ButtonType::Client, "", false, true); ?>
                </div>
            </form>
        </div>
        <div id="security" class="content__security">
    <h3 class="content__security__title">Sécurité</h3>
    <p class="content__security__description">Modifier vos paramètres de sécurités</p>
    <form method="POST" action= "/client/clientForgotPassword/reset-password-action.php">
        <div class="content__security__elements">
            <?php
            Input::render(
                "content__security__elements__password",
                "firstPasswordEntry",
                "password",
                "Modifier Mot de passe",
                "firstPasswordEntry",
                "Mot de passe",
                true,
                "",//"10",
                ""//,"(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=?]).{10,}"
            );
            ?>
            <?php
            Input::render(
                "content__security__elements__password--confirmation",
                "secondPasswordEntry",
                "password",
                "Confirmer Mot de passe",
                "secondPasswordEntry",
                "Confirmer Mot de passe",
                true,
                "",//"10",
                ""//,"(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=?]).{10,}"
            );
            ?>
            <input type="hidden" name="clientId" value="<?php echo ($client->getClientID()) ?>">
            <div class="content__security__elements__modify_button">
                <?php
                require_once ("../../components/Button/Button.php");

                Button::render("button--storybook", "modifier", "Valider les modifications", ButtonType::Client, "", false, true); ?>
            </div>
        </div>
    </form>
</div>

    </main>

    <?php
    require_once ("../../components/Footer/footer.php");
    Footer::render();
    ?>
    <script type="module" src="/client/clientProfile/client-profile.js"></script>
    <script>
        console.log("test :  + <?= $res ?>")
    </script>
</body>

</html>