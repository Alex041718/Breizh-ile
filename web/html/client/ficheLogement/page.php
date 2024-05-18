<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Logement</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="page.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true);
    ?>

    <main>
        <div class="page">
            <div class="photo">
                <h2>Perros-Guirrec 22700</h2>
                <img src="../../assets/images/12345.webp" alt="Image Logement">
            </div>

            <div class="twodiv">
                <div class="details">
                    <h3>Appartement T2</h3>
                    <p>5 personnes • 4 chambres • 5 lits</p>

                    <div class="proprio">
                        <img src="../../assets/images/pp-test.jpg" alt="Proprio Image">
                        <p class="para--18px para--bold">Jade Orlabit</p>
                    </div>

                    <div class="description">
                        <div class="texte">
                            <h4>Description</h4>
                            <p class="para--18px" id="truncate-text">
                            Bienvenue dans notre charmant appartement de deux chambres, situé au cœur de la ville historique de Perros-Guirec, en Bretagne. Cet hébergement spacieux et lumineux offre tout le confort nécessaire pour un séjour inoubliable en famille ou entre amis.

                            L'appartement, récemment rénové, se trouve au deuxième étage d'un immeuble typiquement breton, avec une vue imprenable sur la mer. La décoration moderne et élégante, combinée à des touches traditionnelles, crée une atmosphère chaleureuse et accueillante. Vous apprécierez particulièrement le salon, doté de grandes baies vitrées qui laissent entrer une abondante lumière naturelle. Il est équipé d'un canapé confortable, d'une télévision à écran plat et d'un espace de travail avec une connexion Wi-Fi haut débit.

                            La cuisine entièrement équipée vous permettra de préparer vos repas comme à la maison. Elle comprend un réfrigérateur, un four, un micro-ondes, une cafetière, un lave-vaisselle et une variété d'ustensiles de cuisine. Vous pourrez déguster vos plats dans la salle à manger attenante, qui peut accueillir jusqu'à six personnes.

                            Les deux chambres sont spacieuses et paisibles, offrant chacune un lit double avec des matelas de qualité supérieure pour garantir des nuits reposantes. La chambre principale dispose également d'un dressing et d'un accès direct à une petite terrasse privée, parfaite pour savourer votre café du matin tout en admirant la vue sur l'océan. La deuxième chambre est idéale pour les enfants ou un autre couple, avec suffisamment d'espace pour ranger vos affaires.

                            La salle de bains moderne est équipée d'une douche à l'italienne, d'un lavabo et d'un sèche-serviettes. Pour votre confort, un lave-linge est également à votre disposition dans l'appartement.

                            L'emplacement de l'appartement est l'un de ses principaux atouts. Vous serez à quelques minutes à pied des plages de sable fin, des restaurants locaux, des cafés animés et des boutiques. Perros-Guirec est réputée pour ses paysages côtiers magnifiques et ses sentiers de randonnée, notamment le célèbre sentier des douaniers qui longe la côte de granit rose. Les amateurs de sports nautiques pourront profiter des nombreuses activités disponibles, telles que la voile, le kayak, et la plongée sous-marine.

                            En séjournant chez nous, vous bénéficierez également d'un parking privé gratuit, d'une assistance 24/7 en cas de besoin et de conseils personnalisés pour découvrir les meilleures attractions de la région. Nous mettons tout en œuvre pour que votre séjour soit le plus agréable possible, et nous sommes impatients de vous accueillir dans notre petit coin de paradis breton.

                            Réservez dès maintenant et vivez une expérience mémorable à Perros-Guirec. Vous repartirez avec des souvenirs inoubliables et l'envie de revenir bientôt !
                            </p>
                            <button type="button"><p class="para--bold" id="button-savoir">En savoir +</p></button> 
                        </div>                                        
                    </div>

                    <!-- Pop-up -->
                    <div class="popup-overlay" id="popup-overlay-savoir"></div>
                    <div class="popup" id="popup-savoir">
                        <!-- Contenu de la pop-up (description complète) -->
                        <h3>Description du logement</h3>
                        <p class="para--18px" id="full-description">
                            <!-- Le texte de la description complète sera injecté ici par JavaScript -->
                        </p>
                        <i id="close-popup" class="fa-solid fa-xmark"></i>
                    </div>

                    <button type="button" class="criteres"><p>Afficher les critères</p></button>
                </div>

                <div class="reservation">
                    <h3>60 € par nuit</h3>

                    <div class="preparation">
                        <div class="datepicker">
                            <div class="arrivee">
                                <p class="para--bold">Arrivée:</p>
                                <input class="para--14px" name="startDate" id="start-date" type="date" placeholder="Ajouter une date">
                            </div>

                            <span class="vertical-line"></span>

                            <div class="depart">
                                <p class="para--bold">Départ:</p>
                                <input class="para--14px" name="endDate" id="end-date" type="date" placeholder="Ajouter une date">
                            </div>
                        </div>
                        <div class="nbrClients">
                            <button class="para--bold" id="addTravelersBtn">Ajouter des voyageurs<output id="liveTravelersCount">0</output></button>
                            <div id="popup2" class="popup">
                                <div class="popup-content">
                                    <div class="traveler-type">
                                        <div class="adulteInfo">
                                            <span class="para--bold">Adultes:</span>
                                            <span>13 ans et +</span>
                                        </div>
                                        <div class="addbtn">
                                            <button id="subtractAdultBtn">-</button>
                                            <div class="nbr">
                                                <span id="adultCount">0</span>
                                            </div>
                                            <button id="addAdultBtn">+</button>
                                        </div>
                                    </div>

                                    <div class="traveler-type">
                                        <div class="enfantInfo">
                                            <span class="para--bold">Enfants:</span>
                                            <span>- de 12 ans</span>
                                        </div>
                                        <div class="addbtn">
                                            <button id="subtractChildBtn">-</button>
                                            <div class="nbr">
                                                <span id="childCount">0</span>
                                            </div>
                                            <button id="addChildBtn">+</button>
                                        </div>
                                    </div>
                                    <i id="closePopupBtn" class="fa-solid fa-xmark"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="reservationBtn">
                        <?php 
                            require_once("../../components/Button/Button.php");
                            Button::render("button--storybook", "unId", "<h4>Réserver</h4>", ButtonType::Client, true); 
                        ?>
                    </div>

                    <div class="prix">
                        <div class="calcul">
                            <div><p><u>150 € x 5 nuits</u></p></div>
                            <div><p>750 €</p></div>
                        </div>

                        <div class="horizontal-line"></div>

                        <div class="total">
                            <div><p class="para--bold">Total</p></div>
                            <div><p class="para--bold">750 €</p></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="localisation">
                <div class="local-texte">
                    <h4>Localisation du logement</h4>
                    <i class="fa-solid fa-circle-exclamation tooltip">
                        <span class="tooltip-text"> <p>La localisation exacte sera communiquée une fois la réservation terminée </p></span>
                    </i>
                </div>
                <div id="map"></div>
            </div>

            <div id="overlay"></div>
            
        </div>

        
    </main>

<?php
    require_once("../../components/Footer/footer.php");
    Footer::render();
?>
</body>
<script src="page.js"></script>
</html>
