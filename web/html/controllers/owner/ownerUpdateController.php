<?php

require_once '../../../models/Owner.php';
require_once '../../../services/OwnerService.php';

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
    $ownerID = $_POST['ownerID'];

    $owner = OwnerService::GetOwnerById($ownerID);

    try {
        // Mettre à jour les informations du owner
        $owner->setLastname($lastname);
        $owner->setFirstname($firstname);
        $owner->setNickname($nickname);
        $owner->setMail($mail);
        $owner->setPhoneNumber($phoneNumber);
        $owner->getAddress()->setPostalAddress($address);
        $owner->getGender()->setGenderID($gender);
        $owner->setBirthDate(new DateTime($birthDate));
        $owner->setCreationDate(new DateTime($creationDate));

        // Modifier le owner dans la base de données
        OwnerService::ModifyOwner($owner);

        // Rediriger ou afficher un message de succès
        header('Location: /owner/profil?success=1');
    } catch (Exception $e) {
        // Gérer les erreurs (par exemple, afficher un message d'erreur à l'utilisateur)
        $error = $e->getMessage();
    }
}