<?php
require_once ('../../../services/ClientService.php');
require_once('testPerso.php');
// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifiez si le champ mail est défini et non vide



    // Vérifier si les champs sont corrects


    if(!preg_match("/^([ \x{00C0}-\x{01FF}a-zA-Z'-])+$/u", $_POST['lastname'])) { header("Location: /client/register?error=Nom%20de%20famille%20incorrect."); return; }
    else if(!isset($_POST["genderID"]) || !preg_match("/^[012]$/", $_POST['genderID'])) { header("Location: /client/register?error=Genre%20incorrect."); return; }
    else if(!preg_match("/^([ \x{00C0}-\x{01FF}a-zA-Z'-])+$/u", $_POST['firstname'])) { header("Location: /client/register?error=Prénom%20incorrect."); return; }
    else if(!preg_match("/^[A-Za-z][A-Za-z0-9_]{5,14}$/", $_POST['nickname'])) { header("Location: /client/register?error=Votre%20nom%20d'utilisateur%20ne%20doit%20pas%20contenir%20de%20caractères%20spéciaux%20et%20doit%20faire%20au%20moins%205%20caractères."); return; }
    else if(!preg_match("/(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))/", $_POST['birthDate'])) { header("Location: /client/register?error=Date%20de%20naissance%20incorrecte."); return; }
    else if(!preg_match("/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['mail'])) { header("Location: /client/register?error=Adresse%20email%20incorrecte."); return; }
    else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $_POST['password'])) { header("Location: /client/register?error=Votre%20mot%20de%20passe%20doit%20contenir%20au%20moins%208%20caractères,%20une%20majuscule,%20une%20minuscule%20et%20un%20chiffre."); return; }
    // else if(!preg_match("/[0-9]{3}-[0-9]{2}-[0-9]{3}/", $_POST['phoneNumber'])) { header("Location: /client/register?error=Numéro%20de%20téléphone%20incorrect."); return; }
    else if($_POST['password'] !== $_POST['confirm']) { header("Location: /client/register?error=Les%20mots%20de%20passes%20ne%20correspondent%20pas."); return; }
    
    if (ClientService::isExistingClient($_POST['mail'])) { header("Location: /client/register?error=Un%20compte%20avec%20cette%20adresse%20mail%20existe%20déjà."); return; }

    // Address
    $_POST['addressID'] = 3;

    //Password
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Image
    $image = ImageService::CreateImage(new Image(null, "https://ui-avatars.com/api/?background=random&name=" . $_POST['lastname'] . "+" . $_POST['firstname']));
    $_POST['imageID'] = $image->getImageID();

    //Phone

    //isBlocked
    $_POST['isBlocked'] = 0;

    //CreationDate
    $_POST['creationDate'] = (new DateTime("now"))->format('Y-m-d');

    //ClientID
    $_POST['clientID'] = null;

    //lastConnection
    $_POST['lastConnection'] = null;

    //consent
    $_POST['consent'] = 1;
    
    $client = ClientService::ClientHandler($_POST);

    $email = $_POST['mail'];
    // Appel de la fonction de mise à jour du token, celle-ci retourne également le token
    $code = ClientService::genRandomCode();

    session_start();

    if($client){
        sendmail($code, $email);
        setcookie('account', base64_encode( serialize( $client )), time()+3600, "/", "", true, true);
        setcookie('token', base64_encode( serialize( $code )), time()+3600, "/", "", true, true);
        header("Location: /client/register");
        exit();
    }
} else {
    header("Location: /client/register?error=une%20erreur%20est%20survenue,%20veuillez%20réessayer.");
}