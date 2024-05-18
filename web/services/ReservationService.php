<?php

require_once 'Service.php';
require_once __ROOT__.'/models/Reservation.php';
require_once 'HousingService.php';
require_once 'PayementMethodService.php';

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

    public static function getAllReservationsByOwnerID(int $ownerID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('
            SELECT * FROM _Reservation R 
            JOIN _Housing H ON R.housingID = H.housingID 
            JOIN _Owner O ON H.ownerID = O.ownerID
            WHERE O.ownerID = ' . $ownerID . ';
        ');

        $reservationList = [];

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $reservationList[] = self::ReservationHandler($row);
        }

        return $reservationList;
    }

    public static function ReservationHandler(array $row): Reservation
    {
        //Permet de faire le lien avec le logement de la réservation
        $housing = HousingService::GetHousingById($row[9]);

        $payMethod = PayementMethodService::GetPayementMethodById($row[8]);

        $row[1] = ($row[2] == null) ? new DateTime("now") : new DateTime($row[1]);
        $row[2] = ($row[2] == null) ? new DateTime("now") : new DateTime($row[2]);

        if($row[3] == null) $row[3] = 0.0;
        if($row[4] == null) $row[4] = 0.0;

        return new Reservation($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $housing, $payMethod);
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