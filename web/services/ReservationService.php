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
            SELECT *, R.beginDate as r_begin_date, R.endDate as r_end_date FROM _Reservation R 
            JOIN _Housing H ON R.housingID = H.housingID 
            JOIN _Owner O ON H.ownerID = O.ownerID
            WHERE O.ownerID = ' . $ownerID . '
            ORDER BY R.beginDate;
        ');

        $reservationList = [];

        while ($row = $stmt->fetch()) {
            $reservationList[] = self::ReservationHandler($row);
        }

        return $reservationList;
    }
    
    public static function getAllReservationsByClientID(int $clientID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('
            SELECT *, R.beginDate as r_begin_date, R.endDate as r_end_date FROM _Reservation R 
            JOIN _Housing H ON R.housingID = H.housingID 
            JOIN _Client O ON H.clientID = O.clientID
            WHERE O.clientID = ' . $clientID . '
            ORDER BY R.beginDate;
        ');

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

        $client = ClientService::getClientById($row['clientID']);

        if($row['serviceCharge'] == null) $row['serviceCharge'] = 0.0;
        if($row['touristTax'] == null) $row['touristTax'] = 0.0;

        // Vérifier si 'r_begin_date' est défini et non nul
        if (isset($row['r_begin_date']) && $row['r_begin_date'] !== null) {
            $beginDate = new DateTime($row['r_begin_date']);
        } else {
            // Gérer le cas où 'r_begin_date' n'est pas défini ou est nul
            $beginDate = new DateTime(); // ou une valeur par défaut appropriée
        }

        // Vérifier si 'r_end_date' est défini et non nul
        if (isset($row['r_end_date']) && $row['r_end_date'] !== null) {
            $endDate = new DateTime($row['r_end_date']);
        } else {
            // Gérer le cas où 'r_end_date' n'est pas défini ou est nul
            $endDate = new DateTime(); // ou une valeur par défaut appropriée
        }

        
        return new Reservation($row['reservationID'], $beginDate, $endDate, $row['serviceCharge'], $row['touristTax'], $row['status'], $row['nbPerson'], $housing, $payMethod, $client);

    }

    public static function getReservationByID(int $reservationID): Reservation
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT *, R.beginDate as r_begin_date, R.endDate as r_end_date FROM _Reservation R WHERE reservationID = ' . $reservationID);
        $row = $stmt->fetch();
        return self::ReservationHandler($row);
    }

    public static function getReservationByClientId($clientId): Array
    {
        $pdo = self::getPDO();
        $reservationList = [];
        $stmt = $pdo->query(
            '
                select * from _Reservation 
                where clientID = '. $clientId
        );
        while ($row = $stmt->fetch()) {
            $reservationList[] = self::ReservationHandler($row);
        }
        return $reservationList;
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