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
    <script src="aboutUs.js"></script>
    <link rel="stylesheet" href="../../style/ui.css">
</head>
<body>
    <p id="auth" style="display:none"><?=$isAuthenticated?></p>
    <p id="auth" style="display:none"><?=$isAuthenticated?></p>
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true,false, $isAuthenticated);
    ?>
    <div class="main">
        <div class="about-section">
            <div class="inner-container">
                <h2 id="typing-text">Nous sommes <span id="dynamic-text"></span></h2>
                <p class="para--18px">
                    Breizh'Ile est votre destination privilégiée pour découvrir la beauté et l'authenticité de la Bretagne à travers des locations de logements uniques et confortables. Fondée par une équipe de passionnés de la région, Breizh'Ile s'engage à vous offrir une expérience de séjour inoubliable.               
                </p>
                <h3>Rejoignez-nous</h3>
                <p class="para--18px">Nous sommes ravis de vous accueillir chez Breizh'Ile et de vous aider à créer des souvenirs inoubliables en Bretagne. Rejoignez notre communauté de voyageurs satisfaits et découvrez pourquoi tant de gens choisissent Breizh'Ile pour leurs vacances en Bretagne. <br>

                Pour toute question ou information supplémentaire, n'hésitez pas à nous contacter. Nous sommes là pour vous aider !</p>
            </div>
        </div>
    </div>
    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render();
    ?>
    
</body>