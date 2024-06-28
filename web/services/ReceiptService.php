<?php

require_once 'Service.php';
require_once __ROOT__.'/models/Receipt.php';
require_once 'ReservationService.php';
require_once 'ClientService.php';
require_once 'PayementMethodService.php';


class ReceiptService extends Service
{
    public static function getAllReceipts()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Receipt');
        $receiptList = [];

        while ($row = $stmt->fetch()) {
            $receiptList[] = self::ReceiptHandler($row);
        }

        return $receiptList;
    }

    public static function createReceipt(Receipt $receipt): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Receipt (`ReceiptID`, `reservationID`, `ReceiptDate`, `touristTax`, `totalHT`, `totalTVA`, `totalTTC`, `TVA`, `PaymentDate`, `payMethodID`, `clientID`) VALUES (NULL, :reservationID, :ReceiptDate, :touristTax, :totalHT, :totalTVA, :totalTTC, :TVA, :PaymentDate, :payMethodID, :clientID)');

        $success = $stmt->execute(array(
            'reservationID' => $receipt->getReservation()->getId(),
            'ReceiptDate' => $receipt->getReceiptDate()->format('Y-m-d'),
            'touristTax' => $receipt->getTouristTax(),
            'totalHT' => $receipt->getTotalHT(),
            'totalTVA' => $receipt->getTotalTVA(),
            'totalTTC' => $receipt->getTotalTTC(),
            'TVA' => $receipt->getTVA(),
            'PaymentDate' => $receipt->getPaymentDate() ? $receipt->getPaymentDate()->format('Y-m-d') : null,
            'payMethodID' => $receipt->getPayMethod()->getPayMethodID(),
            'clientID' => $receipt->getClient()->getClientID()
        ));

        if (!$success) {
            throw new Exception('Failed to create receipt');
        }

        return true;
    }

    public static function ReceiptHandler(array $row): Receipt
    {
        $reservation = ReservationService::getReservationByID($row['reservationID']);
        $payMethod = PayementMethodService::GetPayementMethodById($row['payMethodID']);
        $client = ClientService::getClientById($row['clientID']);

        $receiptDate = new DateTime($row['ReceiptDate']);
        $paymentDate = isset($row['PaymentDate']) ? new DateTime($row['PaymentDate']) : null;

        return new Receipt($row['ReceiptID'], $reservation, $receiptDate, $row['touristTax'], $row['totalHT'], $row['totalTVA'], $row['totalTTC'], $row['TVA'], $paymentDate, $payMethod, $client);
    }

    public static function getReceiptByID(int $receiptID): Receipt
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Receipt WHERE ReceiptID = ' . $receiptID);
        $row = $stmt->fetch();
        return self::ReceiptHandler($row);
    }

    public static function getReceiptByReservationID(int $reservationID): ?Receipt
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM _Receipt WHERE reservationID = :reservationID');
        $stmt->execute(['reservationID' => $reservationID]);
        $row = $stmt->fetch();

        return $row ? self::ReceiptHandler($row) : null;
    }

    public static function createReceiptsForReservationsWithoutReceipt(int $clientID)
    {
        // Retrieve all reservations
        $reservations = ReservationService::getReservationByClientId($clientID);

        // Iterate over each reservation
        foreach ($reservations as $reservation) {
            // Check if a receipt already exists for this reservation
            $receipt = ReceiptService::getReceiptByReservationID($reservation->getId());

            // If no receipt exists, create a new one
            if ($receipt === null) {
                // Calculate the necessary values
                $beginDate = $reservation->getBeginDate();
                $endDate = $reservation->getEndDate();
                $intervalDay = $beginDate->diff($endDate)->days;
                $nights = $reservation->getHousingId()->getPriceIncl() * $intervalDay;
                $serviceFee = $nights * 0.01;
                $touristTax = $reservation->getTouristTax();
                $totalTTC = $nights + $serviceFee + $touristTax;
                $TVA = 0.2;
                $totalTVA = $totalTTC * $TVA;
                $totalHT = $totalTTC - $totalTVA;
                $paymentDate = new DateTime();

                // Create a new instance of Receipt with the calculated values
                $newReceipt = new Receipt(null, $reservation, new DateTime(), $touristTax, $totalHT, $totalTVA, $totalTTC, $TVA, $paymentDate, $reservation->getPayMethodId(), $reservation->getClientId());

                // Insert the new receipt into the database
                ReceiptService::createReceipt($newReceipt);
            }
        }
    }


}