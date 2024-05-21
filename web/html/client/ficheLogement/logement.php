<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Logement</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/client/ficheLogement/logement.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="/client/ficheLogement/page.js"></script>
</head>
<body>
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true);
    ?>

    <main class="logement">
        <h2>Perroz-Guirec - 22700</h2>
        <section class="logement__top">
            <div class="logement__top__image">
                <img src="../../assets/images/12345.webp" alt="Image Logement" />
            </div>
            <div class="logement__top__reservation">
                <h3>60€ la nuit</h3>
                <div class="logement__top__reservation__options">
                    <div class="logement__top__reservation__options__dates">
                        <div class="options__arrivee">
                            <h4>Arrivée<h4>
                            <p>17/06/24</p>
                        </div>
                        <div class="options__depart">
                            <h4>Départ<h4>
                            <p>17/06/24</p>
                        </div>
                    </div>
                    <div class="logement__top__reservation__options__voyageurs">
                        <button class="para--bold" id="addTravelersBtn">Ajouter des voyageurs</button>
                        <output id="liveTravelersCount">0</output>
                        <div id="popup2" class="popup">
                            <div class="popup-content">
                                <div class="traveler-type">
                                    <div class="adulteInfo">
                                        <span class="para--bold">Adultes:</span>
                                        <p>13 ans et +</p>
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
                                        <p>- de 12 ans</p>
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
                <button class="order-btn para--18px para--bold">Réserver</button>
                <div class="logement__top__reservation__nuits">
                    <p class="nuits__calculs">150 € x 5 nuits</p>
                    <p class="nuits__total">750 €</p>
                </div>
                <hr>
                <div class="logement__top__reservation__total">
                    <p>Total</p>
                    <p class="total__total">750 €</p>
                </div>
            </div>
        </section>

        <section  class="logement__bottom">
            <div class="logement__bottom__left">
                <div class="logement__bottom__left__info">
                    <div class="logement__bottom__left__info__description">
                        <h3>Appartement T2</h3>
                        <p> 5 personnes - 4 chambres - 5 lits</p>
                    </div>
                    <div class="logement__mid__left__host">
                        <img src="../../assets/images/pp-test.jpg" alt="Proprio Image">
                        <h4>Eric Dupont</h4>
                    </div>
                </div>
                <div class="logement__bottom__left__description">
                    <h3>Description</h3>
                    <p>Idéalement situé pour découvrir la côte de granit rose : à 10 min de Perros-Guirrec et de Beg Legue, à 15 min de trégastel, mon appartement est à proximité des commerces et des restaurants.Au premier étage, dans une résidence calme, vous disposerez d'une chambre (lit 2 places) et d'un canapé lit, d'une cuisine équipée, d'une salle de bain et d'un toilette séparé. Idéalement situé pour découvrir la côte de granit rose : à 10 min de Perros-Guirrec et de Beg Legue, à 15 min de trégastel</p2>
                    <p class="button-savoir" id="button-savoir">En savoir plus+</p>
                    <div class="popup-overlay" id="popup-overlay-savoir"></div>
                        <div class="popup" id="popup-savoir">
                            <!-- Contenu de la pop-up (description complète) -->
                            <h3>Description du logement</h3>
                            <p class="para--18px" id="full-description">
                                <!-- Le texte de la description complète sera injecté ici par JavaScript -->
                            </p>
                            <i id="close-popup" class="fa-solid fa-xmark"></i>
                        </div>

                        <button type="button" class="criteres"><p class="para--bold">Afficher les critères</p></button>
                    </div>
                </div>
            </div>
            <div class="logement__bottom__right">
                <div class="logement__bottom__right__title">
                    <h3>Localisation du logement</h3>
                    <i class="fa-solid fa-circle-exclamation tooltip">
                        <span class="tooltip-text"> <p>La localisation exacte sera communiquée une fois la réservation terminée </p></span>
                    </i>
                </div>
                <div id="map"></div>
                <p class="city">Perroz-Guirec - 22700</p>
            </div>
        </section>            
    </main>

<?php
    require_once("../../components/Footer/footer.php");
    Footer::render();
?>
</body>
</html>
