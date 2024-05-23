<?php

    // C'est la page du devis

    // Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
    require_once '../../../models/Client.php';
    require_once '../../../services/ClientService.php';
    require_once '../../../services/SessionService.php'; // pour le menu du header
    $isAuthenticated = SessionService::isClientAuthenticated();

    // imports
    require_once('../../../models/Bid.php');
    require_once('../../../services/HousingService.php');
    require_once('../../../services/ClientService.php');
    require_once('../../../services/OwnerService.php');



    if (!isset($_SESSION['currentBid'])) {
        header('Location: '. SessionService::get('oldPage') ?? '/');
        exit();
    }

    // on récupère le devis
    $bid = SessionService::get('currentBid');


    // Création du devis avec la deserialization des classes
    /** @var Housing $housing */
    $housing = HousingService::getHousingByID($bid['housing']);
    /** @var Owner $owner */
    $owner = OwnerService::getOwnerByID($bid['owner']);

    // Découpe des variables
    $intervalDay = $bid['interval'];
    $numberPerson = $bid['numberPerson'];
    $beginDate = $bid['beginDate'];
    $endDate = $bid['endDate'];


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

        <h2 class="bid__container__title-page">Votre devis pour séjourné à <?= $housing->getAddress()->getCity() ?> :</h2>

        <div class="bid__container__info">
            <div class="bid__container__info__info-detail">
                <div class="bid__container__info__info-detail__description">
                    <div class="bid__container__info__info-detail__description__image">
                        <img src="<?= $housing->getImage()->getImageSrc() ?>" alt="Image du logement">
                    </div>
                    <div class="bid__container__info__info-detail__description__content">
                        <h3><?= $housing->getTitle() ?></h3>
                        <p class="para--18px>"><?= $housing->getLongDesc() ?></p>
                    </div>
                </div>

                <div class="bid__container__info__info-detail__kpi">
                    <div class="bid__container__info__info-detail__kpi__item"><?= $intervalDay ?> nuits</div>
                    <div class="bid__container__info__info-detail__kpi__item"><?= $numberPerson ?> personnes</div>
                    <!--<div class="bid__container__info__info-detail__kpi__item"><?= $housing->getNbSimpleBed() ?> lit(s) simple(s)</div>
                    <div class="bid__container__info__info-detail__kpi__item"><?= $housing->getNbDoubleBed() ?> lit(s) double(s)</div> -->

                </div>

                <div class="bid__container__info__info-detail__dates">
                    <h3>Du <?= $beginDate->format('d/m/Y') ?> au <?= $endDate->format('d/m/Y') ?></h3>
                </div>
            </div>
            <div class="bid__container__info__pay-recap">

                <div class="bid__container__info__pay-recap__price-detail">
                    <h3>Détails du prix</h3>
                    <?php
                    // CALCUL !

                    $nights = $housing->getPriceIncl()*$intervalDay;
                    $serviceFee = $nights*0.01;
                    $sejourTax = 1*$intervalDay*$numberPerson;
                    $total = $nights + $serviceFee + $sejourTax;
                    ?>

                    <div>
                        <p class="para--18px"><?= $housing->getPriceIncl() ?> € x <?= $intervalDay ?> nuits</p>
                        <p class="para--18px"><?= $nights ?> €</p>
                    </div>
                    <div>
                        <p class="para--18px" >Frais de service</p>
                        <p class="para--18px"><?= $serviceFee  ?> €</p>
                    </div>
                    <div>
                        <p class="para--18px">Taxee de séjour</p>
                        <p class="para--18px"><?= $sejourTax ?> €</p>
                    </div>
                    <hr>
                </div>

                <div class="bid__container__info__pay-recap__price-total">
                    <div>
                        <h3>Total TTC</h3>
                        <p class="para--18px"><?= $total ?> €</p>
                    </div>
                </div>






                    <?php require_once('../../components/Button/Button.php');
                    Button::render("bid__container__info__pay-recap__button","id","Procéder au paiement",ButtonType::Client,"window.location.href = '/logement/payment'",false);
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
