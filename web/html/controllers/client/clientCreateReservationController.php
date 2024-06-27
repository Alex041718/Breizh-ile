<?php

require_once '../../../models/Reservation.php';
require_once '../../../services/ReservationService.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/HousingService.php';
require_once '../../../services/PayementMethodService.php';
require_once '../../../models/Receipt.php';
require_once '../../../services/ReceiptService.php';



// Traitement du formulaire de création
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['beginDate'], $_POST['endDate'], $_POST['serviceCharge'], $_POST['touristTax'], $_POST['status'], $_POST['nbPerson'], $_POST['priceIncl'], $_POST['housingID'], $_POST['payMethodID'], $_POST['clientID'])) {
        // Gérer l'erreur, par exemple en affichant un message à l'utilisateur
        $error = 'Toutes les données requises ne sont pas présentes.';
        var_dump($_POST);
        echo $error;
    } else {
        try {
            $beginDate = new DateTime($_POST['beginDate']);
            $endDate = new DateTime($_POST['endDate']);
        } catch (Exception $e) {
            // Gérer l'erreur, par exemple en affichant un message à l'utilisateur
            $error = 'Les dates fournies ne sont pas valides.';
            echo $error;
            exit();
        }

        $serviceCharge = $_POST['serviceCharge'];
        $touristTax = $_POST['touristTax'];
        $status = $_POST['status'];
        $nbPerson = $_POST['nbPerson'];
        $priceIncl = $_POST['priceIncl'];
        $housingID = $_POST['housingID'];
        $payMethodID = $_POST['payMethodID'];
        $clientID = $_POST['clientID'];

        $client = ClientService::getClientById($clientID);
        $housing = HousingService::getHousingByID($housingID);
        $payMethod = PayementMethodService::getPayementMethodByID($payMethodID);

        // check if the housing is available

        $isOnline = $housing->getIsOnline();

        require_once '../../../services/SessionService.php';

        if (!$isOnline) {
            // redirection vers la page home avec un toast expliquant que le logement n'est plus disponible

            SessionService::createToast('Le logement n\'est plus disponible', 'error');

            header('Location: /');
            exit();

        }

        // Créer une nouvelle instance de Reservation
        $reservation = new Reservation(null, $beginDate, $endDate, $serviceCharge, $touristTax, $status, $nbPerson, $priceIncl, $housing, $payMethod, $client);
        // Créer une nouvelle instance de Receipt

        // calcul
        $intervalDay = $beginDate->diff($endDate)->days;
        $nights = $housing->getPriceIncl()*$intervalDay;
        $serviceFee = $nights*0.01;
        //$sejourTax = 1*$intervalDay*$nbPerson;
        $totalTTC = $nights + $serviceFee + $touristTax;
        $TVA = 0.2;
        $totalTVA = $totalTTC*$TVA;
        $totalHT = $totalTTC - $totalTVA;
        $paymentDate = new DateTime();

        $receipt = new Receipt(null, $reservation, new DateTime(), $touristTax, $totalHT, $totalTVA, $totalTTC, $TVA, $paymentDate, $payMethod, $client);

        // Insérer la nouvelle réservation dans la base de données
        $reservation = ReservationService::createReservation($reservation);
        // Insérer le nouveau reçu dans la base de données

        $receipt->setReservation($reservation);

        ReceiptService::createReceipt($receipt);

        // import de la session


        SessionService::remove('currentBid');

        SessionService::createToast('Réservation créée !', 'success');

        // Rediriger ou afficher un message de succès
        header('Location: /client/reservations-liste?success=1');
        exit();
    }
}

?>
