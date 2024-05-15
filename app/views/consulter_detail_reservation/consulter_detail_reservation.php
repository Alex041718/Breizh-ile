
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/ui.css">
    <link rel="stylesheet" href="/views/consulter_detail_reservation/consulter_detail_reservation.css">
    <link rel="stylesheet" href="/views/components/SearchBar/SearchBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
    <link rel="stylesheet" href="/views/components/Header/header.css">

    <script src="/views/consulter_detail_reservation/consulter_detail_reservation.js"></script>

    <?php // Date picker ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>


<?php
    define('__ROOT__', dirname(dirname(__FILE__)));

    require_once(__ROOT__ . "/components/Header/header.php");
    Header::render(true);
?>

<main>
    <div class="title">
        <div class="title__arrow">
            <img src="/views/assets/images/fleche.png" id="fleche" alt="fleche">
            <h2>Ma réservation</h2>
        </div>
        <div class="title__date">
            <h5>Voyage  à Lannion du 17/06/24 au 21/06/2024</h5>
        </div>
    </div>
    <article class="informations">
        <section class="informations__left">
            <div class="informations__left__logement">
                <img src="/../FILES/images/12345.webp" alt="house">
                <div class="informations__left__logement__info">
                    <h3>Perros-Guirrec - 22700</h3>
                    <p>Appartement T2</p>
                </div>
            </div>
            <hr>
            <div class="informations__left__detail">
                <h3>Détails du prix</h3>
                <div>
                    <p class="para--18px">60€ x 5 nuits x 1 occupant</p>
                    <p class="para--18px">300€</p>
                </div>
                <div>
                    <p class="para--18px" >Frais de service</p>
                    <p class="para--18px">40€</p>
                </div>
                <div>
                    <p class="para--18px">Taxee de séjour</p>
                    <p class="para--18px">20€</p>
                </div>
            </div>
            <hr>
            <div class="informations__left_detail_total">
                <h3>Total TTC</h3>
                <p>360€</p>
            </div>
        </section>
        <section class="informations__right">
            <div class="informations__right__desc">
                <img src="/views/assets/images/jean.png" alt="">
                <div class="informations__right__desc_info">
                    <h3>+33 6 01 02 03 04</h3>
                    <p>jean.michel@hotmail.fr</p>
                </div>
            </div>
            <div>
                <h3>Localisation</h3>
                <div id="map"></div>
                <div>
                    <p class="para--18px">29200 Brest,</p>
                    <p class="para--18px">13 rue des jonquilles</p>
                    <br>
                    <p class="para--14px">Longitude: 48.066153012488115,  Latitude: -2.9670518765727465</p>
                </div>
            </div>
        </section>
    </article>
    
</main>

<?php
    require_once("../components/Footer/footer.php");
    Footer::render();
?>

</html>