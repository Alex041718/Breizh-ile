<?php

// Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php'; // pour le menu du header
$isAuthenticated = SessionService::isClientAuthenticated();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis de la location</title>

    <link rel="stylesheet" href="../../style/ui.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/client/bid/bid.css">
</head>
<body>
<?php
require_once("../../components/Header/header.php");
Header::render(true,false,$isAuthenticated,$_SERVER['REQUEST_URI']);
?>

<main class="bid">
    <span>la barre de progression</span>
    <div class="bid__container">

        <h2 class="bid__title-page">Votre devis pour :</h2>

        <div class="bid__container__info">
            <div class="bid__container__info__info-detail">

            </div>
            <div class="bid__container__info__pay-recap">

                <div class="bid__container__info__pay-recap__price-detail">
                    <h3>Détails du prix</h3>
                    <div>
                        <p class="para--18px"><?= "100 exel" ?> € x <?= "3" ?> nuits x <?= "8"  ?> occupant(s)</p>
                        <p class="para--18px"><?= "500" ?> €</p>
                    </div>
                    <div>
                        <p class="para--18px" >Frais de service</p>
                        <p class="para--18px"><?= "20" ?> €</p>
                    </div>
                    <div>
                        <p class="para--18px">Taxee de séjour</p>
                        <p class="para--18px"><?= "32" ?> €</p>
                    </div>
                </div>
                <hr>
                <div class="informations__left__total">
                    <div>
                        <h3>Total TTC</h3>
                        <p class="para--18px"><?= "800"?> €</p>
                    </div>
                </div>

                <?php require_once('../../components/Button/Button.php');
                Button::render("Payer","id","Procéder au paiement",ButtonType::Client,"alert('Payer')",false);
                ?>


            </div>
        </div>
    </div>
</main>

<?php
require_once("../../components/Footer/footer.php");
Footer::render();
?>
</body>
</html>
