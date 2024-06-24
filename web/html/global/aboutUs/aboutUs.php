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
</head>
<body>
    <p id="auth" style="display:none"><?=$isAuthenticated?></p>
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true,false, $isAuthenticated);
    ?>
    <div class="main">
<div class="container">
        <div class="about-section">
            <h1 id="typing-text">Nous sommes <span id="dynamic-text"></span></h1>
            
            <div class="sub-section">
                <h3>Bienvenue chez Breizh'Ile</h3>
                <p class="para--18px">Breizh'Ile est votre destination privilégiée pour découvrir la beauté et l'authenticité de la Bretagne à travers des locations de logements uniques et confortables. Fondée par une équipe de passionnés de la région, Breizh'Ile s'engage à vous offrir une expérience de séjour inoubliable.</p>
            </div>
            
            <div class="sub-section">
                <h3>Notre mission</h3>
                <p class="para--18px">Notre mission est simple : vous permettre de découvrir la Bretagne dans toute sa splendeur en vous offrant des logements de qualité, soigneusement sélectionnés pour répondre à vos besoins. Que vous soyez en quête d'une escapade romantique, de vacances en famille ou d'un séjour entre amis, nous avons le logement qu'il vous faut.</p>
            </div>
            
            <div class="sub-section">
                <h3>Pourquoi choisir Breizh'Ile ?</h3>
                <h4 class="para--18px">1. Des logements de qualité</h4>
                <p class="para--18px">Nous proposons une vaste gamme de logements, allant des charmantes maisons de pêcheurs aux appartements modernes avec vue sur la mer. Chaque logement est vérifié et approuvé pour garantir votre confort et votre satisfaction.</p>
                
                <h4 class="para--18px">2. Une équipe locale dévouée</h4>
                <p class="para--18px">Notre équipe, basée en Bretagne, connaît la région sur le bout des doigts. Nous sommes là pour vous conseiller et vous aider à planifier votre séjour, afin que vous puissiez profiter au maximum de tout ce que la Bretagne a à offrir.</p>
                
                <h4 class="para--18px">3. Une expérience authentique</h4>
                <p class="para--18px">Nous croyons que chaque voyageur mérite de vivre une expérience authentique. C'est pourquoi nous privilégions des logements qui reflètent le caractère unique et le charme de la Bretagne.</p>
                
                <h4 class="para--18px">4. Un service personnalisé</h4>
                <p class="para--18px">Votre satisfaction est notre priorité. Nous offrons un service client réactif et personnalisé, disponible pour répondre à toutes vos questions et vous assister avant, pendant et après votre séjour.</p>
            </div>
            
            <div class="sub-section">
                <h3>Découvrir la Bretagne avec Breizh'Ile</h3>
                <p class="para--18px">La Bretagne est une région riche en histoire, en culture et en paysages époustouflants. Des côtes sauvages du Finistère aux plages de sable fin de la côte d'Émeraude, en passant par les mystérieuses forêts de Brocéliande, chaque coin de Bretagne a quelque chose d'unique à offrir.</p>
                
                <p class="para--18px">Avec Breizh'Ile, vous pouvez :</p>
                <ul class="para--18px">
                    <li>Explorer les villages pittoresques et les villes historiques.</li>
                    <li>Profiter des nombreuses activités en plein air comme la randonnée, le vélo, la voile et bien plus encore.</li>
                    <li>Déguster la cuisine bretonne, célèbre pour ses crêpes, ses fruits de mer et son cidre.</li>
                    <li>Participer aux festivals locaux et découvrir les traditions bretonnes.</li>
                </ul>
            </div>
            
            <div class="sub-section">
                <h3>Rejoignez-nous</h3>
                <p class="para--18px">Nous sommes ravis de vous accueillir chez Breizh'Ile et de vous aider à créer des souvenirs inoubliables en Bretagne. Rejoignez notre communauté de voyageurs satisfaits et découvrez pourquoi tant de gens choisissent Breizh'Ile pour leurs vacances en Bretagne.</p>
                
                <p class="para--18px">Pour toute question ou information supplémentaire, n'hésitez pas à nous contacter. Nous sommes là pour vous aider !</p>
                <h2>Pour raphael :</h2>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/YNDS1A7tX4E?si=SgofM2iUhBe9qPY1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    </div>
    
    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render();
    ?>
</body>

