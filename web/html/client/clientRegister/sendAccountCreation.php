<?php
require_once ('../../../services/ClientService.php');
require_once('testPerso.php');
// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifiez si le champ mail est défini et non vide



    // Vérifier si les champs sont corrects

    if(!preg_match("/^([ \x{00C0}-\x{01FF}a-zA-Z'-])+$/u", $_POST['lastName'])) header("Location: /client/register?error=Nom%20de%20famille%20incorrect.");
    else if(!preg_match("/^([ \x{00C0}-\x{01FF}a-zA-Z'-])+$/u", $_POST['firstName'])) header("Location: /client/register?error=Prénom%20incorrect.");
    else if(!preg_match("/^[A-Za-z][A-Za-z0-9_]{5,14}$/", $_POST['nickname'])) header("Location: /client/register?error=Nom%20d'utilisateur%20incorrect.");
    else if(!preg_match("/(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))/", $_POST['birthdate'])) header("Location: /client/register?error=Date%20de%20naissance%20incorrecte.");
    else if(!preg_match("/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['mail'])) header("Location: /client/register?error=Adresse%20email%20incorrecte.");
    else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $_POST['password'])) header("Location: /client/register?error=Votre%20mot%20de%20passe%20doit%20contenir%20au%20moins%208%20caractères,%20une%20majuscule,%20une%20minuscule%20et%20un%20chiffre.");
    else if($_POST['password'] !== $_POST['confirm']) header("Location: /client/register?error=Les%20mots%20de%20passes%20ne%20correspondent%20pas.");

    if (isset($_POST['mail']) && !empty($_POST['mail'])) {
        $email = $_POST['mail'];
        // Appel de la fonction de mise à jour du token, celle-ci retourne également le token
        $token = ClientService::updateUserTokenByEmail($email);
        if($token){
            sendmail($token, $email);
            header("Location: /client/register?success=true");
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