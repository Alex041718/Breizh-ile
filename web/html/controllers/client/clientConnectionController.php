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
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['mail']) || !isset($_POST['password']) || !isset($_POST['role']) || $_POST['role'] !== 'client') {
    // Toast d'erreur
    SessionService::createToast('Erreur lors de la connexion', 'error');
    redirect('/client/connection');
}

$mail = $_POST['mail'];
$password = $_POST['password'];

// Récupération de la page de redirection, avec gestion du fallback, quand l'admin veut accéder à une page protégée mais qu'il n'est plus connecté
$redirectPage = $_POST['redirect'] ?? '/client/pageTemporaire.php';

// Vérification des informations de connexion du propriétaire
if (ConnectionService::checkClient($mail, $password)) {

    // Deconnexion de l'utilisateur au cas où il était connecté en tant que propriétaire
    //SessionService::logout();
    // Connexion réussie, gestion de la session
    $id = ConnectionService::getClientID($mail);
    SessionService::authenticate($id, $mail, 'client');

    // Toast de connexion réussie
    SessionService::createToast('Connexion réussie', 'success');
    redirect($redirectPage);

} else {
    // Toast de connexion échouée
    SessionService::createToast('Connexion échouée', 'error');
    // Connexion échouée, redirection vers la page de connexion
    redirect('/client/clientConnection/client_connection.php?error=loginFailed');
}
