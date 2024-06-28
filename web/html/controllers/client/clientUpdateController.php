<?php

require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/ImageService.php'; // Inclure ImageService

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $nickname = $_POST['nickname'];
    $mail = $_POST['mail'];
    $phoneNumber = $_POST['phoneNumber'];
    $address = $_POST['address'];
    $gender = $_POST['genderID'];
    $birthDate = $_POST['birthDate'];
    $creationDate = $_POST['creationDate'];
    $clientID = $_POST['clientID'];

    try {
        // Récupérer le client existant
        $client = ClientService::GetClientById($clientID);

        // Gestion de l'image
        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['profileImage'];

            // Dossier de destination des images
            $uploadDir = __DIR__ . '/../../../uploads/';
            $imagePath = $uploadDir . basename($uploadedFile['name']);

            // Déplacer le fichier téléchargé vers le dossier d'upload
            move_uploaded_file($uploadedFile['tmp_name'], $imagePath);

            // Créer une nouvelle entrée d'image si nécessaire
            $image = new Image(null, '/uploads/' . basename($uploadedFile['name']));
            $savedImage = ImageService::CreateImage($image);

            // Mettre à jour l'image du client
            $client->getImage()->setImageSrc($savedImage->getImageSrc());
        }

        // Mettre à jour les autres informations du client
        $client->setLastname($lastname);
        $client->setFirstname($firstname);
        $client->setNickname($nickname);
        $client->setMail($mail);
        $client->setPhoneNumber($phoneNumber);
        $client->getAddress()->setPostalAddress($address);
        $client->getGender()->setGenderID($gender);
        $client->setBirthDate(new DateTime($birthDate));
        $client->setCreationDate(new DateTime($creationDate));

        // Modifier le client dans la base de données
        ClientService::ModifyClient($client);

        // Rediriger avec un message de succès
        header('Location: /client/profile?success=1');
        exit();
    } catch (Exception $e) {
        // Gérer les erreurs (par exemple, afficher un message d'erreur à l'utilisateur)
        $error = $e->getMessage();
    }
}
?>
