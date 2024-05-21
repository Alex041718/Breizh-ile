<?php
// imports
require_once '../../services/SessionService.php';

// Gestion de la session
SessionService::system('admin','/admin/dashboard');

// Récupération des propriétaires de la plateforme
require_once '../../services/OwnerService.php';
$owners = OwnerService::GetAllOwners();

// Récupération des genres de la plateforme
require_once '../../services/GenderService.php';
$genders = GenderService::GetAllGenders();

?>

<html>
    <head>
        <title>Les propriétaires</title>
        <link rel="stylesheet" href="../style/ui.css">
        <link rel="stylesheet" href="styleDashboard.css">
    </head>
    <body>
        <h2>Gestion des propriétaires</h2>
        <a href="adminDashboard.php">Retour au tableau de bord</a>
        <h3>Ajouter un propriétaire</h3>
        <form action="/controllers/admin/adminAddOwnerController.php" method="post" enctype="multipart/form-data">
            <label for="identityCard">Carte d'identité</label>
            <input type="text" name="identityCard" id="identityCard">
            <label for="mail">Mail</label>
            <input type="text" name="mail" id="mail">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname">
            <label for="nickname">Surnom</label>
            <input type="text" name="nickname" id="nickname">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
            <label for="phoneNumber">Numéro de téléphone</label>
            <input type="text" name="phoneNumber" id="phoneNumber">
            <label for="birthDate">Date de naissance</label>
            <input type="date" name="birthDate" id="birthDate">
            <label for="consent">Consentement</label>
            <input type="checkbox" name="consent" id="consent">

            <label for="image">Image</label>
            <input type="file" name="image" id="image">

            <label for="city">Ville</label>
            <input type="text" name="city" id="city">

            <label for="postalCode">Code postal</label>
            <input type="text" name="postalCode" id="postalCode">

            <label for="postalAddress">Adresse postale</label>
            <input type="text" name="postalAddress" id="postalAddress">

            <label for="genderID">Genre</label>
            <select name="genderID" id="genderID">
                <?php foreach ($genders as $gender): ?>
                    <option value="<?= $gender->getGenderID() ?>"><?= $gender->getLabel() ?></option>

                <?php endforeach; ?>


            <input type="submit" value="Créer le propriétaire">
        </form>

        <h3>Les propriétaires</h3>
        <table>
            <tr>
                <th>Carte d'identité</th>
                <th>Mail</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Surnom</th>
                <th>Mot de passe</th>
                <th>Numéro de téléphone</th>
                <th>Date de naissance</th>
                <th>Consentement</th>
                <th>Dernière connexion</th>
                <th>Date de création</th>
                <th>Image</th>
                <th>Genre</th>
                <th>Adresse</th>
            </tr>
            <?php
            // imports
            require_once '../../services/OwnerService.php';

            // Récupération des propriétaires de la plateforme
            $owners = OwnerService::GetAllOwners();

            foreach ($owners as $owner) {
                echo '<tr>';
                echo '<td>' . $owner->getIdentityCard() . '</td>';
                echo '<td>' . $owner->getMail() . '</td>';
                echo '<td>' . $owner->getFirstname() . '</td>';
                echo '<td>' . $owner->getLastname() . '</td>';
                echo '<td>' . $owner->getNickname() . '</td>';
                echo '<td>' . $owner->getPassword() . '</td>';
                echo '<td>' . $owner->getPhoneNumber() . '</td>';
                echo '<td>' . $owner->getBirthDate()->format('Y-m-d') . '</td>';
                echo '<td>' . $owner->getConsent() . '</td>';
                echo '<td>' . $owner->getLastConnection()->format('Y-m-d') . '</td>';
                echo '<td>' . $owner->getCreationDate()->format('Y-m-d') . '</td>';
                echo '<td>' . $owner->getImage()->getImageID() . '</td>';
                echo '<td>' . $owner->getGender()->getGenderID() . '</td>';
                echo '<td>' . $owner->getAddress()->getAddressID() . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
</html>
