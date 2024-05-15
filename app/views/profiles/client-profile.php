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
    "..\..\FILES\images\avatar.webp" // imageSrc
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="../style/ui.css">
    <style>
        body {
            margin: 0;
        }

        .content {
            padding-bottom: 70px;
            /* Ajouter un espace pour éviter que le footer ne chevauche le contenu */
            width: 60%;
            margin: 0 auto;
        }

        h3 {
            padding-top: 10px;
            text-decoration: underline #307B5C;
        }

        .round-image-container {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            overflow: hidden;
            float: right;
            margin-left: 10px;
        }

        .round-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .round-image:hover {
            cursor: pointer;
        }

        header,
        footer {
            background-color: #307B5C;
            width: 100%;
        }

        header {
            height: 30px;
        }

        footer {

            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            height: 50px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            border-left-color: transparent;
            border-right-color: transparent;
        }

        .search-bar--storybook {
            display: none;
        }

        /* Style des onglets */
        .tabs {
            overflow: hidden;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            float: left;
            cursor: pointer;
            padding: 8px 16px;
        }

        .tab.active {
            background-color: #ddd;
        }

        #selecteur {
            position: fixed;
            left: 5em;
            top: 10em;
    margin-bottom: 20px;
    list-style-type: none;
    padding: 0;
}



#selecteur li:hover {
    background-color: #f0f0f0;
}

#selecteur li.active {
    background-color: #ddd;
}
    </style>
</head>

<body>

    <header>
        <!-- Search Bar -->
        <?php
        require_once ("../components/SearchBar/SearchBar.php");
        SearchBar::render("search-bar--storybook", "", "./monSuperFormulaireQuiVaEtreTraiter");
        ?>
        blabla
    </header>
    <div class="content">

        <ul id="selecteur" style="float: left; margin-right: 20px;">
            <li data-tab="informations-personnelles">Informations Personnelles</li>
            <li data-tab="securite">Sécurite</li>
        </ul>
        <div id="informations-personnelles" class="tab-content active">
            <h3>Informations Personnelles</h3>
            <p>Modifier vos informations Personnels</p>
            <!-- Photo de profil -->
            <div class="image-container">
                <div class="round-image-container">
                    <img class="round-image" src="<?php echo $client->getImage()->getImageSrc(); ?>" alt=""
                        onclick="changeProfilePicture()">
                    <input type="file" id="fileInput" style="display: none;" accept=".jpg, .jpeg, .png, .webp"
                        onchange="previewImage(event)">
                </div>
            </div>
            <table>
                <tr>
                    <th>Nom</th>
                    <td><?php echo $client->getLastname(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo $client->getFirstname(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Pseudo</th>
                    <td><?php echo $client->getNickname(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Numéro de téléphone</th>
                    <td><?php echo $client->getPhoneNumber(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Adresse email</th>
                    <td><?php echo $client->getMail(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Date d'anniversaire</th>
                    <td><?php echo $client->getBirthDate()->format('Y-m-d'); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Genre</th>
                    <td><?php echo $client->getGender()->getLabel(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
                <tr>
                    <th>Adresse</th>
                    <td><?php echo $client->getAddress()->getPostalAddress(); ?></td>
                    <td><a href="#">Modifier</a></td>
                </tr>
            </table>
        </div>
        <div id="securite" class="tab-content" style="display: none">
            <h3>Sécurité</h3>
            <p>Modifier vos paramètres de sécurités</p>
            <table>
                <tr>
                    <th>Mot de Passe</th>
                    <td>Réinitialiser votre mot de passe régulièrement pour avoir un compte sécurisé</td>
                    <td><a href="#">Réinitialiser</a></td>
                </tr>
                <tr>
                    <th>Supprimer le compte</th>
                    <td>Supprimer définitivement votre compte</td>
                    <td><a href="#">Supprimer</a></td>
                </tr>
            </table>
        </div>


    </div>

    <footer>
        blabla
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('#selecteur li');
    var tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(function (tab, index) {
        tab.addEventListener('click', function () {
            var selectedTabId = this.getAttribute('data-tab');

            tabs.forEach(function (tab) {
                tab.classList.remove('active');
            });

            tabContents.forEach(function (content) {
                content.style.display = 'none';
            });

            this.classList.add('active');
            document.getElementById(selectedTabId).style.display = 'block';
        });
    });
});




    </script>

</body>

</html>