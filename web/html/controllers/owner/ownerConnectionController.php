<?php
/**
 * Admin Connection Controller
 *
 * Ce fichier est le contrôleur de la page de connexion de l'administrateur.
 * Il récupère les données du formulaire de connexion et les utilise pour vérifier les informations de connexion de l'administrateur.
 */
// Import de la classe SessionService
require_once '../../../services/SessionService.php';
require_once '../../../services/ConnectionService.php';


// Récupération de la page de redirection, avec gestion du fallback, quand l'admin veut accéder à une page protégée mais qu'il n'est plus connecté
$redirectPage = $_POST['redirect'] ?? '/back/reservations';

$redirectPage = urldecode($redirectPage);
function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

// Vérifier la méthode de la requête et l'existence des données
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['mail']) || !isset($_POST['password']) || !isset($_POST['role']) || $_POST['role'] !== 'owner') {
    redirect('/back/connection' . ($redirectPage ? '?redirect=' . $redirectPage : ''));
}

$mail = $_POST['mail'];
$password = $_POST['password'];



// Vérification des informations de connexion du propriétaire
if (ConnectionService::checkOwner($mail, $password)) {
    // Connexion réussie, gestion de la session
    $id = ConnectionService::getOwnerID($mail);
    SessionService::authenticate($id, $mail, 'owner');

    redirect($redirectPage);
} else {
    // Connexion échouée, redirection vers la page de connexion
    redirect('/back/connection?error=loginFailed' . ($redirectPage ? '&redirect=' . $redirectPage : ''));
}

?>
