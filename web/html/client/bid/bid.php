<?php

    // C'est la page du devis

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

        <h2 class="bid__container__title-page">Votre devis pour séjourné à Lannion :</h2>

        <div class="bid__container__info">
            <div class="bid__container__info__info-detail">
                <div class="bid__container__info__info-detail__description">
                    <div class="bid__container__info__info-detail__description__image">
                        <img src="https://bretagnelocationvacances.fr/assets/images/055634003/54/petit/54a.jpg" alt="Image de l'appartement">
                    </div>
                    <div class="bid__container__info__info-detail__description__content">
                        <h3>Appartement 2 pièces</h3>
                        <p class="para--18px>">pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.</p>
                    </div>
                </div>

                <div class="bid__container__info__info-detail__kpi">
                    <div class="bid__container__info__info-detail__kpi__item">3 nuits</div>
                    <div class="bid__container__info__info-detail__kpi__item">3 personnes</div>
                    <div class="bid__container__info__info-detail__kpi__item">3 lits</div>

                </div>

                <div class="bid__container__info__info-detail__dates">
                    <h3>Du 25/12/2021 au 28/12/2021</h3>
                </div>
            </div>
            <div class="bid__container__info__pay-recap">

                <div class="bid__container__info__pay-recap__price-detail">
                    <h3>Détails du prix</h3>
                    <div>
                        <p class="para--18px"><?= "100" ?> € x <?= "3" ?> nuits x <?= "8"  ?> occupant(s)</p>
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
                    <hr>
                </div>

                <div class="bid__container__info__pay-recap__price-total">
                    <div>
                        <h3>Total TTC</h3>
                        <p class="para--18px"><?= "800"?> €</p>
                    </div>
                </div>


                <?php require_once('../../components/Button/Button.php');
                Button::render("bid__container__info__pay-recap__button","id","Procéder au paiement",ButtonType::Client,"alert('Payer')",false);
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
