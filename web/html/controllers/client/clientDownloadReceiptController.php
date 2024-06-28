<?php

// Inclure l'autoloader personnalisé
require 'autoload.php';

// Utiliser les classes Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationID = isset($_POST['reservationID']) ? $_POST['reservationID'] : '-1';

    // --------------------------------------------------------------------- Données nécessaires

    // importation des services
    require_once('../../../services/ReceiptService.php');
    require_once ('../../../services/ReservationService.php');

    // Réccupérer l'objet Receipt
    $receipt = ReceiptService::getReceiptByReservationID($reservationID);


    // Réccupérer l'objet Reservation
    $reservation = ReservationService::getReservationByID($reservationID);



    // --------------------------------------------------------------------- Générer le PDF
    ob_start();
    include 'receipt/receiptTemplate.php';
    $html = ob_get_clean();

    // Initialiser Dompdf
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Télécharge le fichier PDF
    $dompdf->stream("document.pdf", array("Attachment" => false));
    exit(0);
    // --------------------------------------------------------------------- Fin de la génération du PDF
}
?>
