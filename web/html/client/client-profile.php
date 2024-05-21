<?php
require_once '../../models/Client.php';
require_once '../../models/Image.php';
require_once '../../models/Gender.php';
require_once '../../models/Address.php';
require_once '../../services/ClientService.php';
// Création d'une instance de la classe Address
$address = new Address(
    null, // addressID
    "Paris", // city
    "75000", // postalCode
    "3 rue des bouleaux" // postalAddress
);

// Création d'une instance de la classe Image
$image = new Image(
    null, // imageID
    "..\assets\images\pp-test.jpg" // imageSrc
);

// Création d'une instance de la classe Gender
$gender = new Gender(
    null, // genderID
    "Féminin" // label
);

// Création d'une instance de la classe Client avec les données fournies
/*$client = new Client(
    1, // clientID
    false, // isBlocked
    "martin.albert@gmail.com", // mail
    "Martine", // firstname
    "Albert", // lastname
    "LaCarry78", // nickname
    "MotDePasse", // password
    "06 70 42 56 37", // phoneNumber
    new DateTime("1990-01-01"), // birthDate
    true, // consent
    new DateTime(), // lastConnection
    new DateTime(), // creationDate
    $image, // image
    $gender, // gender
    $address // address
);*/

$client_data = ClientService::GetClientById(2);
var_dump($client_data);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="client-profile.css">

</head>

<body>

    <?php
    require_once ("../components/Header/header.php");
    Header::render();
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

            <img class="content__personnal-data__image" src="<?php echo $client->getImage()->getImageSrc(); ?>"
                    alt="photo_de_profile">

            <div class="content__personnal-data__elements">

                <!-- Nom -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Nom", "le name",  $client->getLastname(), true); ?>

                <!-- Prenom -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Prenom", "le name", $client->getFirstname()); ?>

                <!-- Pseudo -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Pseudo", "le name", $client->getNickname()); ?>

                <!-- Mail -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "email", "Mail", "le name", $client->getMail()); ?>

                <!-- Telephone -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "tel", "Telephone", "le name", $client->getPhoneNumber()); ?>

                <!-- Adresse -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Adresse", "le name", $client->getAddress()->getPostalAddress()); ?>

                <!-- Genre -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Genre", "le name", $client->getGender()->getLabel()); ?>

                <!-- Date d'anniversaire -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "Date d'anniversaire", "le name", $client->getBirthDate()->format('Y-m-d')); ?>

                <!-- Date de création du compte -->
                <?php require_once ("../components/Input/Input.php");
                Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "Date de création du compte", "le name", $client->getCreationDate()->format('Y-m-d')); ?>
            </div>
        </div>
        <div class="content__security" style="display: none">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>

            <div class="content__security__elements">

                <?php require_once ("../components/Input/Input.php");
                Input::render("content__security__elements__password", "UnIdEnPlus", "password", "Mot de passe", "le name", "Mot de passe", true); ?>


                <?php require_once ("../components/Button/Button.php");
                Button::render("button--storybook", "unId", "Désactiver mon compte", ButtonType::Delete, true); ?>

                <?php require_once ("../components/Button/Button.php");
                Button::render("button--storybook", "unId", "Supprimer mon compte", ButtonType::Delete, true); ?>

            </div>
        </div>
    </div>

    <?php
    require_once ("../components/Footer/footer.php");
    Footer::render();
    ?>
    <script src="/client/client-profile.js"></script>

</body>

</html>