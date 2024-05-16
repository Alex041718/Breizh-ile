<?php
require_once '../../models/Client.php';
require_once '../../models/Image.php';
require_once '../../models/Gender.php';
require_once '../../models/Address.php';

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
$client = new Client(
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
);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="wclassth=device-wclassth, initial-scale=1.0">
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
            <p class="content__personnal-data__description">Modifier vos informations Personnels</p>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Nom", "le name", "Nom", true); ?>


            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Prenom", "le name", "Prenom", true); ?>


            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Pseudo", "le name", "Pseudo", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "email", "Mail", "le name", "Mail", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Genre", "le name", "Genre", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "tel", "Telephone", "le name", "Telephone", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "Date d'anniversaire", "le name", "Date d'anniversaire", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "Date de création du compte", "le name", "Date de création du compte", true); ?>

            <img class="content__personnal-data__image" src="<?php echo $client->getImage()->getImageSrc(); ?>" alt="">

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "Adresse", "le name", "Adresse", true); ?>

        </div>
        <div class="content__security" style="display: none">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>


            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "password", "Mot de passe", "le name", "Mot de passe", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "button", "Désactiver son compte", "le name", "Désactiver son compte", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "button", "Supprimer mon compte", "le name", "Supprimer mon compte", true); ?>

        </div>
    </div>

    <?php
    require_once ("../components/Footer/footer.php");
    Footer::render();
    ?>
    <script src="/client/client-profile.js"></script>

</body>

</html>