<?php
/*
 * Ce fichier est un test pour la création d'un propriétaire
 *
 */





// Importation des classes
require_once '../services/ImageService.php';
require_once '../services/AddressService.php';
require_once '../services/OwnerService.php';
require_once '../services/GenderService.php';

// On va créer un Owner

// création d'une image pour le profil du propriétaire
$image = new Image(null, '/FILES/images/12345.webp'); // on crée une image avec un ID null et un chemin d'accès à une image



// création d'une adresse pour le propriétaire
$address = new Address(null, 'Brest', '75000', '5 rue de la liberté');





// Choix d'un genre
$gender = genderService::GetGenderById(1); // on récupère le genre par son ID, on aurait pu aussi tous les récupérer avec la méthode GetAllGenders() de la classe GenderService


for ($i = 0; $i < 5; $i++) { // création de 5 propriétaires

    // Création d'un propriétaire
    $owner = new Owner(null, '123456789', strval($i . 'proprio@gmail.com'), 'Jean', 'Dupont', 'JD', '123456', '0607080910', new DateTime('1990-01-01'), true, new DateTime(), new DateTime(), $image, $gender, $address);

    // Enregistrement du propriétaire dans la base de données
    $owner = OwnerService::CreateOwner($owner);
    // cela va aussi enregistrer l'image et l'adresse du propriétaire

}

echo '5 propriétaires ont été créés (normalement)';
echo 'Si le script est réexécuté, une erreur sera levée car il y a une contrainte d\'unicité sur le mail de l\'owner';
?>
