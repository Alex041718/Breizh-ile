<?php
require_once('../../../services/ClientService.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['firstPasswordEntry'], $_POST['secondPasswordEntry'], $_POST['clientId'])) {
        if($_POST['firstPasswordEntry'] == $_POST['secondPasswordEntry']){
            $newPassword = $_POST['firstPasswordEntry'];
            $clientId = $_POST['clientId'];

            // Vérifier que le nouveau mot de passe n'est pas égal à l'ancien mot de passe
            $client = ClientService::GetClientById($clientId);
            if (!$client) {
                // Gérer l'erreur (client non trouvé)
                echo "Client non trouvé.";
                return false;
            }

            $currentPassword = $client->getPassword(); // Récupérer le mot de passe actuel (à adapter selon ton modèle)
            if($newPassword === $currentPassword) {
                // Gérer l'erreur (mot de passe identique à l'ancien)
                echo "Le nouveau mot de passe ne peut pas être identique à l'ancien.";
                return false; // ou gérer autrement l'erreur
            }

            // Vérification du format du mot de passe avec regex
            $passwordPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=?]).{10,}$/';
            if (!preg_match($passwordPattern, $newPassword)) {
                // Gérer l'erreur (format du mot de passe incorrect)
                echo "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre, un caractère spécial et faire au moins 10 caractères de long.";
                //ClientService::updateUserPasswordByClientId("zizi", $clientId);

                return false;
            }
            else{
                echo"Duncan a un gros zizi";
                ClientService::updateUserPasswordByClientId($newPassword, $clientId);
                return true;
            }

            // Mettre à jour le mot de passe
            // FIXME : Ajouter un message de succès

            // Redirection vers une page par exemple
            // header("Location: /");
            // exit();
        } else {
            // Gérer l'erreur (les mots de passe ne correspondent pas)
            echo "Les mots de passe ne correspondent pas.";
            return false;
        }
    } else {
        // Gérer l'erreur (les champs requis ne sont pas présents dans la requête)
        echo "Tous les champs requis ne sont pas fournis.";
        return false;
    }
}
?>
