<?php
require_once('../../../services/OwnerService.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['firstPasswordEntry'], $_POST['token'], $_POST['secondPasswordEntry'], $_POST['clientId'])) {
        $newPassword = $_POST['firstPasswordEntry'];
        $clientId = $_POST['clientId'];

        if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $_POST['firstPasswordEntry'])) { header("Location: /client/reset-password?token=" . $_POST["token"] . "&error=Votre%20mot%20de%20passe%20doit%20contenir%20au%20moins%208%20caractères,%20une%20majuscule,%20une%20minuscule%20et%20un%20chiffre."); return; }
        else if($_POST['firstPasswordEntry'] !== $_POST['secondPasswordEntry']) { header("Location: /client/reset-password?token=" . $_POST["token"] . "&error=Les%20mots%20de%20passes%20ne%20correspondent%20pas."); return; }

        // Mettre à jour le mot de passe
        // FIXME : Ajouter un message de succès

        // Redirection vers une page par exemple
        OwnerService::updateUserPasswordByOwnerId($newPassword, $clientId);
        header("Location: /back/reset-password?token=" . $_POST["token"] . "&success=true");
        // exit();
        // Gérer l'erreur (les mots de passe ne correspondent pas)

    } else {
        // Gérer l'erreur (les champs requis ne sont pas présents dans la requête)
        header("Location: /client/reset-password?token=" . $_POST["token"] . "&error=Veuillez%20sasir%20de%20tous%20les%20champs.");
        return false;
    }
}
?>
