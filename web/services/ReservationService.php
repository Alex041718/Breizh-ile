<?php

require_once 'Service.php';
require_once __ROOT__.'/models/Reservation.php';
require_once 'HousingService.php';

class ReservationService extends Service
{
    public static function getAllReservations()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Reservation');
        $reservationList = [];

        while ($row = $stmt->fetch()) {
            $reservationList[] = self::ReservationHandler($row);
        }

        return $reservationList;
    }

    public static function ReservationHandler(array $row): Reservation
    {
        //Permet de faire le lien avec le logement de la réservation
        $housing = HousingService::GetHousingById($row['housingID']);

        $payMethod = PayementMethodService::GetPayementMethodById($row['payMethodId']);

        return new Reservation($row['reservationID'], $row['beginDate'], $row['endDate'], $row['serviceCharge'], $row['touristTax'], $row['status'], $housing, $payMethod);
    }
}