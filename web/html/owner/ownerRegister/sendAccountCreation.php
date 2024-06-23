<?php
require_once ('../../../services/OwnerService.php');
require_once ('../../../services/ClientService.php');
require_once('testPerso.php');
// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifiez si le champ mail est défini et non vide

    $allowed = array('png', 'jpg', 'jpeg', 'webp');

    // Vérifier si les champs sont corrects

    if(!preg_match("/^([ \x{00C0}-\x{01FF}a-zA-Z'-])+$/u", $_POST['lastname'])) { header("Location: /back/register?error=Nom%20de%20famille%20incorrect."); return; }
    else if(!isset($_POST["genderID"]) || !preg_match("/^[012]$/", $_POST['genderID'])) { header("Location: /back/register?error=Genre%20incorrect."); return; }
    else if(!preg_match("/^([ \x{00C0}-\x{01FF}a-zA-Z'-])+$/u", $_POST['firstname'])) { header("Location: /back/register?error=Prénom%20incorrect."); return; }
    else if(!preg_match("/^[A-Za-z][A-Za-z0-9_]{5,14}$/", $_POST['nickname'])) { header("Location: /back/register?error=Votre%20nom%20d'utilisateur%20ne%20doit%20pas%20contenir%20de%20caractères%20spéciaux%20et%20doit%20faire%20au%20moins%205%20caractères."); return; }
    else if(!preg_match("/(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))/", $_POST['birthDate'])) { header("Location: /back/register?error=Date%20de%20naissance%20incorrecte."); return; }
    else if(!preg_match("/^[\w\.-]+@([\w-]+\.)+[\w-]{2,4}$/", $_POST['mail'])) { header("Location: /back/register?error=Adresse%20email%20incorrecte."); return; }
    else if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $_POST['password'])) { header("Location: /back/register?error=Votre%20mot%20de%20passe%20doit%20contenir%20au%20moins%208%20caractères,%20une%20majuscule,%20une%20minuscule%20et%20un%20chiffre."); return; }
    else if(!in_array(pathinfo($_FILES['identityCard']["name"], PATHINFO_EXTENSION), $allowed)) { header("Location: /back/register?error=La%20carte%20d'identité%20n'est%20pas%20au%20bon%20format."); return; }
    else if($_FILES['identityCard']['size'] > 10 * 1024 * 1024) { header("Location: /back/register?error=Le%20fichier%20fourni%20est%20trop%20volumineux."); return; }
    else if($_POST['password'] !== $_POST['confirm']) { header("Location: /back/register?error=Les%20mots%20de%20passes%20ne%20correspondent%20pas."); return; }
    
    if (OwnerService::isExistingOwner($_POST['mail'])) { header("Location: /back/register?error=Un%20compte%20avec%20cette%20adresse%20mail%20existe%20déjà."); return; }

    // Address
    $_POST['addressID'] = 3;

    //Password
    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Image
    $image = ImageService::CreateImage(new Image(null, "https://ui-avatars.com/api/?background=random&name=" . $_POST['lastname'] . "+" . $_POST['firstname']));
    $_POST['imageID'] = $image->getImageID();

    //isBlocked
    $_POST['isValidate'] = 0;

    $ext = explode('.', $_FILES['identityCard']['name']);
    $ext = strtolower(end($ext));
    $new_name = uniqid('', true) . '.' . $ext;
    $destination = '/var/www/uploads/' . $new_name;

    $destination = '/var/www/uploads/' . $new_name;

    move_uploaded_file($_FILES['identityCard']['tmp_name'], $destination);

    //isBlocked
    $_POST['identityCard'] = $destination;

    //CreationDate
    $_POST['creationDate'] = (new DateTime("now"))->format('Y-m-d');

    //OwnerID
    $_POST['ownerID'] = null;

    //lastConnection
    $_POST['lastConnection'] = null;

    //consent
    $_POST['consent'] = 1;
    
    $owner = OwnerService::OwnerHandler($_POST);

    $email = $_POST['mail'];
    // Appel de la fonction de mise à jour du token, celle-ci retourne également le token
    $code = ClientService::genRandomCode();

    session_start();

    if($owner){
        sendmail($code, $email);
        setcookie('accountOwner', base64_encode( serialize( $owner )), time()+3600, "/", "", true, true);
        setcookie('tokenOwner', base64_encode( serialize( $code )), time()+3600, "/", "", true, true);
        header("Location: /back/register");
        exit();
    }
} else {
    header("Location: /back/register?error=une%20erreur%20est%20survenue,%20veuillez%20réessayer.");
}