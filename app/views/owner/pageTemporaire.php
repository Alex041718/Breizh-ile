<?php
// imports
require_once '../../services/SessionService.php';


// !!! !!!!!! Ceci est à mettre dans chaque page qui nécessite une session/connection


// Gestion de la session
SessionService::system('owner','../../views/owner/ownerConnection.php');





// on va afficher des info sur le propriétaire connecté

// on va récupérer les infos du propriétaire connecté
require_once '../../services/OwnerService.php';
$owner = OwnerService::getOwnerById($_SESSION['user_id']);


?>

<html>
    <head>
        <title>Page temporaire</title>
    </head>
    <body>
        <h1>Page temporaire</h1>
        <p>Te voilà connecté</p>
        <p>Voici tes informations :</p>
        <?php var_dump($owner); ?>

    </body>
</html>
