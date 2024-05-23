<?php
require_once("../../../services/ClientService.php");
require_once("../../components/Input/Input.php");

$token = $_GET["token"];

$user = ClientService::GetClientByToken($token);

date_default_timezone_set('Europe/Paris');
$time = time();
//Check si on a récupéré un utilisateur
if ($user == null) {
    die("Token invalide");
}
if (($user->getResetTokenExpiration()->getTimestamp()) < $time) {
    die("Token expiré");
}

//echo "Token valide";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Reset password</h1>
<!--    TODO : vérifier si token tjr valide + toast si réussite ou erreur-->
    <form method="post" action="reset-password-action.php">
        <input type="hidden" name="clientId" value="<?php echo $user->getClientID(); ?>">
        <?php Input::render("firstPasswordEntry","password","password","Nouveau mot de passe","firstPasswordEntry","",true); ?>
        <?php Input::render("secondPasswordEntry","password","password","Confirmer le mot de passe","secondPasswordEntry","",true); ?>
        <button type="submit">Sauvegarder</button>
    </form>

</body>
</html>
