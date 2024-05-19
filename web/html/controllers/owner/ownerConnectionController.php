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

function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

// Vérifier la méthode de la requête et l'existence des données
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['role']) || $_POST['role'] !== 'owner') {
    redirect('/owner/ownerConnection/owner_connection.php');
}

$username = $_POST['username'];
$password = $_POST['password'];

// Récupération de la page de redirection, avec gestion du fallback, quand l'admin veut accéder à une page protégée mais qu'il n'est plus connecté
$redirectPage = $_POST['redirect'] ?? '/owner/pageTemporaire.php';

// Vérification des informations de connexion du propriétaire
if (ConnectionService::checkOwner($username, $password)) {
    // Connexion réussie, gestion de la session
    $id = ConnectionService::getOwnerID($username);
    SessionService::authenticate($id, $username, 'owner');

    redirect($redirectPage);
} else {
    // Connexion échouée, redirection vers la page de connexion
    redirect('/owner/ownerConnection/owner_connection.php?error=loginFailed');
}

?>
