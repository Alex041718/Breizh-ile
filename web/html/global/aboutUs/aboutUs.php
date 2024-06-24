<?php 
    // ------------------- Systeme de session -------------------
    // Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
    require_once '../../../models/Client.php';
    require_once '../../../services/ClientService.php';
    require_once '../../../services/SessionService.php'; // pour le menu du header

    // Vérification de l'authentification de l'utilisateur

    $isAuthenticated = SessionService::isClientAuthenticated();
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A propos de nous</title>
    <link rel="stylesheet" href="aboutUs.css">
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true,false, $isAuthenticated);
    ?>
    
    <div class="container">
        <h3 id="typing-text">Nous sommes </h3>
    </div>
    <script src="aboutUs.js"></script>
</body>
</html>
