<?php
/*
 * Ce fichier est le contrôleur du formulaire d'ajout d'un propriétaire du dashboard Administrateur. Il récupère les données du formulaire et les utilise pour créer un objet Owner.
 */

// Imports
require_once '../../services/Service.php';
require_once '../../services/OwnerService.php';
require_once '../../services/GenderService.php';

// Vérifier la méthode de la requête et l'existence des données

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['identityCard']) || !isset($_POST['mail']) || !isset($_POST['firstname']) || !isset($_POST['lastname']) || !isset($_POST['nickname']) || !isset($_POST['password']) || !isset($_POST['phoneNumber']) || !isset($_POST['birthDate']) || !isset($_POST['consent']) || !isset($_POST['genderID']) || !isset($_POST['city']) || !isset($_POST['postalCode']) || !isset($_POST['postalAddress'])) {

    header('Location: /views/admin/ownerDashboard.php?error=missingFields');
    exit();
}

// Récupération des données du formulaire
$identityCard = $_POST['identityCard'];
$mail = $_POST['mail'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$phoneNumber = $_POST['phoneNumber'];
$birthDate = new DateTime($_POST['birthDate']);
$consent = $_POST['consent'] === 'true';
$genderID = $_POST['genderID'];

// Création de l'objet Image

$target_dir = "../../FILES/images/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
// Enregistrement de l'image dans le dossier FILES
$path = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
// objet Image
$image = new Image(null, '/FILES/images/'. basename($_FILES["image"]["name"]));

// Récupération des données de l'adresse du formulaire afin de construire l'objet Address
$city = $_POST['city'];
$postalCode = $_POST['postalCode'];
$postalAddress = $_POST['postalAddress'];
$address = new Address(null, $city, $postalCode, $postalAddress);


// Récupération des données du genre depuis la base de données afin de construire l'objet Genre
$genre = GenderService::GetGenderById($genderID);


// Création de l'objet Owner
$owner = new Owner(null, $identityCard, $mail, $firstname, $lastname, $nickname, $password, $phoneNumber, $birthDate, $consent, new DateTime(), new DateTime(), $image, $genre, $address);

// Ajout du propriétaire dans la base de données

$owner = OwnerService::CreateOwner($owner);

// Redirection vers le dashboard Administrateur
header('Location: /views/admin/ownerDashboard.php?success=ownerCreated');
exit();
