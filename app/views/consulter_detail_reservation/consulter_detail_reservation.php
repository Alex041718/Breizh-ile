
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
    <script src="./home/script.js"></script>
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script>
    <script src="./components/Helper/autocompletionHelper.js" defer></script>
    <script src="./components/SearchBar/SearchBar.js" defer></script>
    <link rel="stylesheet" href="/views/components/Header/header.css">

    <?php // Date picker ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<?php
    require_once("../components/Header/header.php");
    Header::render(true);
?>

<main>
    <div>
        <img src="/views/assets/images/fleche.png" id="fleche" alt="fleche">
        <h2>Ma réservation</h2>
        <div>
            <h5>Voyage  à Lannion du 17/06/24 au 21/06/2024</h5>
        </div>
    </div>
    <article>
        <section>
            <div id="infos-logement">
                <div class="image-container">
                    <img src="/views/assets/images/house.png" alt="house">
                </div>
                <div class="info">
                    <h3>Perros-Guirrec - 22700</h3>
                    <p>Appartement T2</p>
                </div>
            </div>
            <div id="detail">
                <h3>Détails du prix</h3>
                <div>
                    <p>60€ x 5 nuits x 1 occupant</p>
                    <p>300€</p>
                </div>
                <div>
                    <p>Frais de service</p>
                    <p>40€</p>
                </div>
                <div>
                    <p>Taxee de séjour</p>
                    <p>20€</p>
                </div>
            </div>
            <div id="total">
                <h3>Total TTC</h3>
                <p>360€</p>
            </div>
        </section>
        <section id="section-2">
            <div>
                
            </div>
            <div>
                
            </div>
        </section>
    </article>
    
</main>

<?php
    require_once("../components/Footer/footer.php");
    Footer::render();
?>

</html>