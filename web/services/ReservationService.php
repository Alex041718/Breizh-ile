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

        $payMethod = PayementMethodService::GetPayementMethodById($row['payMethodID']);

        if(is_string($row['beginDate'])) $row['beginDate'] = new DateTime("now");
        if(is_string($row['endDate'])) $row['endDate'] = new DateTime("now");

        if($row['serviceCharge'] == null) $row['serviceCharge'] = 0.0;
        if($row['touristTax'] == null) $row['touristTax'] = 0.0;

        return new Reservation($row['reservationID'], $row['beginDate'], $row['endDate'], $row['serviceCharge'], $row['touristTax'], $row['status'], $housing, $payMethod);
    }

    public static function getReservationByID(int $reservationID): Reservation
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Reservation WHERE reservationID = ' . $reservationID);
        $row = $stmt->fetch();
        return self::ReservationHandler($row);
    }

    public static function getNbJoursReservation(string $beginDate, string $dateFin): int
    {
        $dateDebut = new DateTime($beginDate);
        $dateFin = new DateTime($dateFin);
        if ($dateDebut != $dateFin){
            return $dateDebut->diff($dateFin)->days;
        }
        else{
            return 0;
        }
    }

}