<?php
// imports
require_once '../../services/SessionService.php';

// Gestion de la session
SessionService::system('admin','/admin/dashboard');

// Récupération des logements de la plateforme
require_once '../../services/HousingService.php';
$housings = HousingService::GetAllHousings();

// Récupération des types de logements de la plateforme
require_once '../../services/TypeService.php';
$types = TypeService::GetAllTypes();

// Récupération des catégories de logements de la plateforme
require_once '../../services/CategoryService.php';
$categories = CategoryService::GetAllCategories();

// Récupération des propriétaires de logements de la plateforme
require_once '../../services/OwnerService.php';
$owners = OwnerService::GetAllOwners();


?>

<html>
    <head>
        <title>Les logements</title>
        <link rel="stylesheet" href="../style/ui.css">
        <link rel="stylesheet" href="styleDashboard.css">
    </head>
    <body>
        <h2>Gestion des logements</h2>
        <a href="adminDashboard.php">Retour au tableau de bord</a>
        <h3>Ajouter un logement</h3>
        <form action="/controllers/admin/adminAddHousingController.php" method="post">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title">
            <label for="shortDesc">Description courte</label>
            <input type="text" name="shortDesc" id="shortDesc">
            <label for="longDesc">Description longue</label>
            <input type="text" name="longDesc" id="longDesc">
            <label for="priceExcl">Prix HT</label>
            <input type="number" name="priceExcl" id="priceExcl">
            <label for="priceIncl">Prix TTC</label>
            <input type="number" name="priceIncl" id="priceIncl">
            <label for="nbRoom">Nombre de pièces</label>
            <input type="number" name="nbRoom" id="nbRoom">
            <label for="nbDoubleBed">Nombre de lits doubles</label>
            <input type="number" name="nbDoubleBed" id="nbDoubleBed">
            <label for="nbSimpleBed">Nombre de lits simples</label>
            <input type="number" name="nbSimpleBed" id="nbSimpleBed">
            <label for="longitude">Longitude</label>
            <input type="number" name="longitude" id="longitude">
            <label for="latitude">Latitude</label>
            <input type="number" name="latitude" id="latitude">
            <label for="isOnline">En ligne</label>
            <input type="checkbox" name="isOnline" id="isOnline">
            <label for="noticeCount">Date de préavis</label>
            <input type="number" name="noticeCount" id="noticeCount">
            <label for="beginDate">Date de début</label>
            <input type="date" name="beginDate" id="beginDate">
            <label for="endDate">Date de fin</label>
            <input type="date" name="endDate" id="endDate">
            <label for="surfaceInM2">Surface en m²</label>
            <input type="number" name="surfaceInM2" id="surfaceInM2">

            <label for="city">Ville</label>
            <input type="text" name="city" id="city">

            <label for="postalCode">Code postal</label>
            <input type="text" name="postalCode" id="postalCode">

            <label for="postalAddress">Adresse postale</label>
            <input type="text" name="postalAddress" id="postalAddress">

            <!-- selection du type -->
            <label for="typeID">Type</label>
            <select name="typeID" id="typeID">
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type->getTypeID() ?>"><?= $type->getLabel() ?></option>
                <?php endforeach; ?>
            </select>

            <!-- selection de la catégorie -->
            <label for="categoryID">Catégorie</label>
            <select name="categoryID" id="categoryID">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->getCategoryID() ?>"><?= $category->getLabel() ?></option>
                <?php endforeach; ?>
            </select>


            <!-- selection du propriétaire -->
            <label for="ownerID">Propriétaire</label>
            <select name="ownerID" id="ownerID">
                <?php foreach ($owners as $owner): ?>
                    <option value="<?= $owner->getOwnerID() ?>"><?= $owner->getFirstname() . ' ' . $owner->getLastname() ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Créer le logment">
        </form>
        <h3>Liste des logements</h3>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description courte</th>
                    <th>Description longue</th>
                    <th>Prix HT</th>
                    <th>Prix TTC</th>
                    <th>Nombre de pièces</th>
                    <th>Nombre de lits doubles</th>
                    <th>Nombre de lits simples</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>En ligne</th>
                    <th>Delai de préavis</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Date de création</th>
                    <th>Surface en m²</th>
                    <th>Type</th>
                    <th>Catégorie</th>
                    <th>Adresse</th>
                    <th>Propriétaire</th>
                    <th>Images</th>
                    <th>Aménagements</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($housings as $housing): ?>
                    <tr>
                        <td><?= $housing->getTitle() ?></td>
                        <td><?= $housing->getShortDesc() ?></td>
                        <td><?= $housing->getLongDesc() ?></td>
                        <td><?= $housing->getPriceExcl() ?></td>
                        <td><?= $housing->getPriceIncl() ?></td>
                        <td><?= $housing->getNbRoom() ?></td>
                        <td><?= $housing->getNbDoubleBed() ?></td>
                        <td><?= $housing->getNbSimpleBed() ?></td>
                        <td><?= $housing->getLongitude() ?></td>
                        <td><?= $housing->getLatitude() ?></td>
                        <td><?= $housing->getIsOnline() ?></td>
                        <td><?= $housing->getNoticeCount() ?></td>
                        <td><?= $housing->getBeginDate() ?></td>
                        <td><?= $housing->getEndDate() ?></td>
                        <td><?= $housing->getCreationDate() ?></td>
                        <td><?= $housing->getSurfaceInM2() ?></td>
                        <td><?= $housing->getType()->getName() ?></td>
                        <td><?= $housing->getCategory()->getName() ?></td>
                        <td><?= $housing->getAddress()->getStreet() . ' ' . $housing->getAddress()->getNumber() . ', ' . $housing->getAddress()->getZipCode() . ' ' . $housing->getAddress()->getCity() ?></td>
                        <td><?= $housing->getOwner()->getFirstName() . ' ' . $housing->getOwner()->getLastName() ?></td>
                        <td>
                            <ul>
                                <?php foreach ($housing->getImages() as $image): ?>
                                    <li><img src="<?= $image->getUrl() ?>" alt="<?= $image->getAlt() ?>"></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <?php foreach ($housing->getArrangement() as $arrangement): ?>
                                    <li><?= $arrangement->getName() ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
