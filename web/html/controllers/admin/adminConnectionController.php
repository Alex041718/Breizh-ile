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
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['username']) || !isset($_POST['password'])) {
    redirect('/admin/connection');
}

$username = $_POST['username'];
$password = $_POST['password'];

// Récupération de la page de redirection, avec gestion du fallback, quand l'admin veut accéder à une page protégée mais qu'il n'est plus connecté
$redirectPage = $_POST['redirect'] ?? '/admin/dashboard';

// Vérification des informations de connexion de l'administrateur
if (ConnectionService::checkAdmin($username, $password)) {
    // Connexion réussie, gestion de la session
    $id = ConnectionService::getAdminID($username);
    SessionService::authenticate($id, $username, 'admin');


    redirect($redirectPage);
} else {
    // Connexion échouée, redirection vers la page de connexion
    redirect('/admin/connection?error=loginFailed');
}

?>
