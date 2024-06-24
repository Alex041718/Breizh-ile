<?php
require_once ('../../../services/OwnerService.php');
require_once('testPerso.php');
// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si le champ mail est défini et non vide
    if (isset($_POST['mail']) && !empty($_POST['mail'])) {
        $email = $_POST['mail'];

        if(!OwnerService::isExistingOwner($email)) {
            header("Location: /back/forgot-password?success=true");
            return;
        }
        // Appel de la fonction de mise à jour du token, celle-ci retourne également le token
        $token = OwnerService::updateUserTokenByEmail($email);
        if($token){
            sendmail($email, $token);
            header("Location: /back/forgot-password?success=true");
            exit();
        }
        header("Location: /back/forgot-password?error=%20Une%20erreur%20est%20survenue%20durant%20la%20soumission%20du%20formulaire.");
    } else {
        header("Location: /back/forgot-password?error=%20Une%20erreur%20est%20survenue%20durant%20la%20soumission%20du%20formulaire.");

    }
} else {
    header("Location: /back/forgot-password?error=%20Une%20erreur%20est%20survenue%20durant%20la%20soumission%20du%20formulaire.");
}

