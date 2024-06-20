<?php
// Import des services nécessaires
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php';

// Vérifier l'authentification du client
SessionService::system('client', '/logement/payment');
$isAuthenticated = SessionService::isClientAuthenticated();

// Sur cette page le client est obligatoirement connecté grace au système de session
// donc on peut récupérer les informations du client
$clientID = $_SESSION['user_id'];
$client = ClientService::getClientById($clientID);

// imports
require_once('../../../models/Bid.php');
require_once('../../../services/HousingService.php');
require_once('../../../services/ClientService.php');
require_once('../../../services/OwnerService.php');


if (!isset($_SESSION['currentBid'])) {
    header('Location: ' . SessionService::get('oldPage') ?? '/');
    exit();
}

// Import des services nécessaires
require_once '../../../models/Client.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/SessionService.php';

// Vérifier l'authentification du client
SessionService::system('client', '/logement/payment');
$isAuthenticated = SessionService::isClientAuthenticated();

// Sur cette page le client est obligatoirement connecté grace au système de session
// donc on peut récupérer les informations du client
$clientID = $_SESSION['user_id'];
$client = ClientService::getClientById($clientID);





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


// CALCUL !
//--------------------------------
$nights = $housing->getPriceIncl() * $intervalDay;
$serviceFee = $nights * 0.01;
$sejourTax = 1 * $intervalDay * $numberPerson;
$total = $nights + $serviceFee + $sejourTax;
//--------------------------------

// payment method
require_once('../../../services/PayementMethodService.php');
$paymentMethods = PayementMethodService::GetPayementMethodById(1);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Validation du paiement</title>
    <link rel="stylesheet" type="text/css" href="/client/reservationPayment/reservation-payment.css">
    <link rel="stylesheet" href="../../style/ui.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <div class="reservation-payment" >

        <form class="reservation-payment__container" action="/controllers/client/clientCreateReservationController.php" method="post">
            <h2 class="reservation-payment__container__title">Validation du paiement</h2>

            <p>Votre séjour à <?= $housing->getAddress()->getCity() ?></p>
            <p>Du <b><?= $beginDate->format('d/m/Y'); ?></b> au <b><?= $endDate->format('d/m/Y'); ?></b></p>
            <h3 class="reservation-payment__container__price-to-pay"><?= $total ?>€</h3>

                <?php require_once ("../../components/Button/Button.php"); ?>
            <div class="reservation-payment__container__button-box">

                <?php Button::render("reservation-payment__container__button", "submit", "Annuler", ButtonType::Delete, "history.back()", true, false); ?>

                <?php Button::render("reservation-payment__container__button", "submit", "Valider le paiement", ButtonType::Client, "", false, true); ?>

            </div>


            <input type="hidden" name="beginDate" value="<?= $beginDate->format('d-m-Y'); ?>">

            <input type="hidden" name="endDate" value="<?= $endDate->format('d-m-Y'); ?>">

            <input type="hidden" name="serviceCharge" value="<?php echo $serviceFee; ?>">

            <input type="hidden" name="touristTax" value="<?php echo $sejourTax; ?>">

            <input type="hidden" name="status" value="<?php echo "Prochainement"; ?>">

            <input type="hidden" name="nbPerson" value="<?php echo $numberPerson; ?>">

            <input type="hidden" name="priceIncl" value="<?php echo $housing->getPriceIncl(); ?>">

            <input type="hidden" name="housingID" value="<?php echo $housing->getHousingID(); ?>">

            <input type="hidden" name="payMethodID" value="<?php echo $paymentMethods->getPayMethodId(); ?>">
            <input type="hidden" name="clientID" value="<?php echo $client->getClientID(); ?>">


        </form>
    </div>
</body>
</html>
