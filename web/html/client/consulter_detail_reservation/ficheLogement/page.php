<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Logement</title>
    <link rel="stylesheet" href="../style/ui.css">
    <link rel="stylesheet" href="page.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    

</head>
<body>  

<?php
        
        define('__HEADER__', dirname(dirname(__FILE__)));

        require_once("../components/Header/header.php");
        Header::render(true);
    ?>
    
    <main>
        <div class="page">

            <div class="photo">
                <h2>Perros-Guirrec 22700</h2>
                <img src="../../FILES/images/12345.webp" alt="Image Logement">
            </div>

            <div class="twodiv">

                <div class="details">
                    <h4>Appartement T2</h4>
                    <p>5 personnes • 4 chambres • 5 lits</p>

                    <div class="proprio">
                        <img src="../../FILES/images/thispersondoesnotexist.com.jpeg" alt="Image Proprio">
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

                        <button type="button"> <p class="para--bold">En savoir +</p></button>
                        
                    </div>

                    <Button type="button" class="criteres"> <p>Afficher les critères</p></Button>

                </div>

                <div class="reservation">
                    <h4>60 € par nuit</h4>
                    <div class="datepicker">
                        
                        <div class="arrivee" >
                            <p>Arrivée:</p>
                            <input class="para--14px" name="startDate" id="start-date" type="date" placeholder="Ajouter une date">
                        </div>
                        
                        <div class="depart" >
                            <p>Départ:</p>
                            <input class="para--14px" name="endDate" id="end-date" type="date" placeholder="Ajouter une date">
                        </div>

                    
                    </div>
 
                </div>

            </div>

        </div>
        
    </main>
    

</body>

<script src="page.js"></script>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche Logement</title>
    <link rel="stylesheet" href="../style/ui.css">
    <link rel="stylesheet" href="page.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    

</head>
<body>  

<?php
        
        define('__ROOT__', dirname(dirname(__FILE__)));

        require_once("../components/Header/header.php");
        Header::render(true);
    ?>
    
    <main>
        <div class="page">

            <div class="photo">
                <h2>Perros-Guirrec 22700</h2>
                <img src="../../FILES/images/12345.webp" alt="Image Logement">
            </div>

            <div class="twodiv">

                <div class="details">
                    <h4>Appartement T2</h4>
                    <p>5 personnes • 4 chambres • 5 lits</p>

                    <div class="proprio">
                        <img src="../../FILES/images/thispersondoesnotexist.com.jpeg" alt="Image Proprio">
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

                        <button type="button"> <p class="para--bold">En savoir +</p></button>
                        
                    </div>

                    <Button type="button" class="criteres"> <p>Afficher les critères</p></Button>

                </div>

                <div class="reservation">
                    <h4>60 € par nuit</h4>
                    <div class="datepicker">
                        
                        <div class="arrivee" >
                            <p>Arrivée:</p>
                            <input class="para--14px" name="startDate" id="start-date" type="date" placeholder="Ajouter une date">
                        </div>
                        
                        <div class="depart" >
                            <p>Départ:</p>
                            <input class="para--14px" name="endDate" id="end-date" type="date" placeholder="Ajouter une date">
                        </div>

                    
                    </div>
 
                </div>

            </div>

        </div>
        
    </main>
    

</body>

<script src="page.js"></script>

</html>