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

// Création d'une image pour le profil du propriétaire
$image = ImageService::CreateImage('/FILES/images/12345.webp');



// création d'une adresse pour le propriétaire
$address = new Address(null, 'Brest', '75000', '5 rue de la liberté');
// Enregistrement de l'adresse dans la base de données
$address = AddressService::CreateAddress($address);




// Choix d'un genre
$gender = genderService::GetGenderById(1); // on récupère le genre par son ID, on aurait pu aussi tous les récupérer avec la méthode GetAllGenders() de la classe GenderService


// Création d'un propriétaire
$owner = new Owner(null, '123456789', 'proprioQuiAunLoge@gmail.com', 'Jean', 'Dupont', 'JD', '123456', '0607080910', new DateTime('1990-01-01'), true, new DateTime(), new DateTime(), $image, $gender, $address);

// Enregistrement du propriétaire dans la base de données
$owner = OwnerService::CreateOwner($owner);



// réccupération d'un type pour le logement
$type = TypeService::GetTypeById(1); // on récupère le type par son ID, on aurait pu aussi tous les récupérer avec la méthode GetAllTypes() de la classe TypeService

// réccupération d'une catégorie pour le logement
$category = CategoryService::GetCategoryById(1); // on récupère la catégorie par son ID, on aurait pu aussi tous les récupérer avec la méthode GetAllCategories() de la classe CategoryService

// création d'une adresse pour le logement, celle pour le logement, différente de celle du propriétaire
$addressDuLog = new Address(null, 'Brest', '75000', '6 rue de la liberté');

// Enregistrement de l'adresse dans la base de données
$addressDuLog = AddressService::CreateAddress($addressDuLog);

// Création d'un logement
$housing = new Housing(null, 'Super logement', 'Un logement de rêve', 'Un logement de rêve, vraiment', 1000, 1200, 5, 2, 3, 48.4, -4.5, true, new DateTime(), new DateTime(), new DateTime(), new DateTime(), 120, $type, $category, $addressDuLog, $owner, [], []);

?>
