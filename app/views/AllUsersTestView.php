<?php

require_once '../services/UserService.php';
require_once './components/UserCard.php';

use views\components\UserCard;
use services\UserService;

// Récupération de tous les utilisateurs
$users = UserService::GetAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="path/to/your/user-card.css">
</head>
<body>
    <h1>Ce sont des données provenant de la base de donnés</h1>
    <?php foreach ($users as $user): ?>
        <?php UserCard::renderUserCard($user); ?>
    <?php endforeach; ?>
</body>
</html>
