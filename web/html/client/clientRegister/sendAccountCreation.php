<?php
require_once ('../../../services/ClientService.php');
require_once('testPerso.php');
// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si le champ mail est défini et non vide
    if (isset($_POST['mail']) && !empty($_POST['mail'])) {
        $email = $_POST['mail'];
        // Appel de la fonction de mise à jour du token, celle-ci retourne également le token
        $token = ClientService::updateUserTokenByEmail($email);
        if($token){
            sendmail($token, $email);
            header("Location: /");
            exit();
        }
        echo "Le token de réinitialisation a été envoyé si l'email est correct.";
    } else {
        echo "Aucun email fourni.";
    }
} else {
    echo "Formulaire non soumis correctement.";
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<p>Si l'email fourni est correct, un lien de réinitialisation a été envoyé.</p>
</body>
<script>
    window.location.href="/";
</script>
</html>
