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
    //require_once ("../components/Header/header.php");
    //Header::render();
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
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "le label", "le name", "lePlaceHolder", true); ?>


            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "le label", "le name", "lePlaceHolder", true); ?>


            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "le label", "le name", "lePlaceHolder", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "email", "le label", "le name", "lePlaceHolder", true); ?>
 
            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "le label", "le name", "lePlaceHolder", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "tel", "le label", "le name", "lePlaceHolder", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "le label", "le name", "lePlaceHolder", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "date", "le label", "le name", "lePlaceHolder", true); ?>

            <img class="content__personnal-data__image" src="<?php echo $client->getImage()->getImageSrc(); ?>" alt="">

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "text", "le label", "le name", "lePlaceHolder", true); ?>

        </div>
        <div class="content__security">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>


            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "password", "le label", "le name", "lePlaceHolder", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "button", "le label", "le name", "lePlaceHolder", true); ?>

            <?php require_once ("../components/Input/Input.php");
            Input::render("uneClassEnPlus", "UnIdEnPlus", "button", "le label", "le name", "lePlaceHolder", true); ?>

        </div>
    </div>

    <?php
    //require_once ("../components/Footer/footer.php");
    //Footer::render();
    ?>
    <script>
        // Sélectionnez tous les divs enfants de .content__selector
        const divs = document.querySelectorAll('.content__selector > div');

        // Ajoutez la classe content__selector--current au premier div
        divs[0].classList.add('content__selector--current');

        // Définissez l'élément actuel comme étant le premier div
        let currentDiv = divs[0];

        // Ajoutez un écouteur d'événements à chaque div
        divs.forEach(div => {
            div.addEventListener('click', function () {
                if (div !== currentDiv) {
                    if (currentDiv !== null) {
                        currentDiv.classList.remove('content__selector--current');
                    }
                    div.classList.add('content__selector--current');
                    currentDiv = div;
                }
            });
        });
    </script>

</body>

</html>