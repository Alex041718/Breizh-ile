<?php
require_once('../../../services/ClientService.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['firstPasswordEntry'] == $_POST['secondPasswordEntry']){
        $newPassword = $_POST['firstPasswordEntry'];
        $clientId = $_POST['clientId'];
        ClientService::updateUserPasswordByClientId($newPassword, $clientId);
        //FIXME : Ajouter un message de succès
        header("Location: /");
    }

}
