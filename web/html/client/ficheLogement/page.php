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
                    <h4>Appartement T2</h4>
                    <p>5 personnes • 4 chambres • 5 lits</p>

                    <div class="proprio">
                        <img src="../../assets/images/pp-test.jpg" alt="Proprio Image">
                        <p class="para--bold">Jade Orlabit</p>
                    </div>

                    <div class="description">
                        <div class="texte">
                            <h4>Description</h4>
                            <p class="para--18px">
                                Idéalement situé pour découvrir la côte de granit rose : 
                                à 10 min de Perros-Guirrec et de Beg Legue, à 15 min de trégastel, 
                                mon appartemnce calme, vous disposerez d'une chambre (lit 2 places) et 
                                d'un canapé lit, d'une cuisine équipée, d'une salle de bain et d'un toilette séparé...
                            </p>
                        </div>
                        <button type="button"><p class="para--bold">En savoir +</p></button>
                    </div>

                    <button type="button" class="criteres"><p>Afficher les critères</p></button>
                </div>

                <div class="reservation">
                    <h4>60 € par nuit</h4>

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
                            <button class="para--bold" id="addTravelersBtn">Ajouter des voyageurs <output id="liveTravelersCount">0</output></button>
                            <div id="popup" class="popup">
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
                <h4>Localisation du logement</h4>
                <div id="map"></div>
            </div>
        </div>
    </main>
</body>
<script src="page.js"></script>
</html>
