
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/ui.css">
    <link rel="stylesheet" href="/views/consulter_detail_reservation/consulter_detail_reservation.css">
</head>

<?php
    require_once("../components/Header/header.php");
    Header::render();
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