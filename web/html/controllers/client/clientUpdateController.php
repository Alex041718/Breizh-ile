<?php

require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';

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
    $password = $_POST['password'];

    $client = ClientService::GetClientById($clientID);

    try {
        // Mettre à jour les informations du client
        $client->setLastname($lastname);
        $client->setFirstname($firstname);
        $client->setNickname($nickname);
        $client->setMail($mail);
        $client->setPhoneNumber($phoneNumber);
        $client->getAddress()->setPostalAddress($address);
        $client->getGender()->setGenderID($gender);
        $client->setBirthDate(new DateTime($birthDate));
        $client->setCreationDate(new DateTime($creationDate));
        $client->setPassword($password);

        // Modifier le client dans la base de données
        ClientService::ModifyClient($client);

        // Rediriger ou afficher un message de succès
        header('Location: /client/profil?success=1');
    } catch (Exception $e) {
        // Gérer les erreurs (par exemple, afficher un message d'erreur à l'utilisateur)
        $error = $e->getMessage();
    }
}

?>