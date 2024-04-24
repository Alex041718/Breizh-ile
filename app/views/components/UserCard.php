<?php
namespace views\components;

use model\User;


// Ceci est un test


class UserCard {

    public static function renderUserCard(User $user) {
        // Import du fichier CSS pour le composant
        echo '<link rel="stylesheet" href="userCard.css">';

        // Début du composant UserCard
        echo '<div class="user-card">';

        // Affichage des informations de l'utilisateur
        echo '<h3>' . htmlspecialchars($user->firstName . " " . $user->lastName) . '</h3>';
        echo '<p>Nom d\'utilisateur: ' . htmlspecialchars($user->name) . '</p>';
        echo '<p>Email: ' . htmlspecialchars($user->email) . '</p>';
        echo '<p>Rôle: ' . htmlspecialchars($user->role) . '</p>';

        // Fin du composant UserCard
        echo '</div>';
    }
}

?>