<?php

require_once 'Service.php';
require_once __ROOT__.'/models/Reservation.php';
require_once 'HousingService.php';
require_once 'PayementMethodService.php';
require_once 'ClientService.php';

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
            WHERE O.ownerID = ' . $ownerID . '
            ORDER BY R.beginDate;
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
        $housing = HousingService::GetHousingById($row['housingID']);
        
        $payMethod = PayementMethodService::GetPayementMethodById($row['payMethodID']);

        $client = ClientService::getClientById($row['clientID']);

        if($row['serviceCharge'] == null) $row['serviceCharge'] = 0.0;
        if($row['touristTax'] == null) $row['touristTax'] = 0.0;

        $beginDate = new DateTime($row['beginDate']);
        $endDate = new DateTime($row['endDate']);
        
        return new Reservation($row['reservationID'], $beginDate, $endDate, $row['serviceCharge'], $row['touristTax'], $row['status'], $row['nbPerson'], $housing, $payMethod, $client);

    }

    public static function getReservationByID(int $reservationID): Reservation
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Reservation WHERE reservationID = ' . $reservationID);
        $row = $stmt->fetch();
        return self::ReservationHandler($row);
    }

    public static function getNbJoursReservation(DateTime $beginDate, DateTime $endDate): int
    {
        if ($beginDate != $endDate){
            return $beginDate->diff($endDate)->days;
        }
        else{
            return 1;
        }
    }
}