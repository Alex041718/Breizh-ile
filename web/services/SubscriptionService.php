<?php

require_once 'Service.php';
require_once __ROOT__.'/models/Reservation.php';
require_once __ROOT__.'/models/Subscription.php';
require_once 'HousingService.php';
require_once 'PayementMethodService.php';
require_once 'ClientService.php';

class SubscriptionService extends Service
{

    public static function CreateSubscription(Subscription $subscription, Array $reservations): Subscription
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Subscription (subscriptionID, token, beginDate, endDate, userID) VALUES (:subscriptionID, :token, :beginDate, :endDate, :userID);');

        $stmt->execute(array(
            'subscriptionID' => $subscription->getId(),
            'token' => $subscription->getToken(),
            'beginDate' => $subscription->getBeginDate(),
            'endDate' => $subscription->getEndDate(),
            'userID' => $subscription->getUserID(),
        ));

        $current_id = $pdo->lastInsertId();
        
        foreach ($reservations as $reservation) {
            $stmt = $pdo->prepare('INSERT INTO _Has_for_subscription (subscriptionID , reservationID ) VALUES (:clientID, :reservationID);');

            $stmt->execute(array(
                'subscriptionID' => $current_id,
                'reservationID' => $reservation->getID(),
            ));
        }

        

        return new Subscription($current_id, $subscription->getToken(), $subscription->getBeginDate(), $subscription->getEndDate(), $subscription->getUserID());
    }

    public static function getSubscriptionByToken(string $token)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM _Subscription WHERE token = '" . $token . "';");
        $row = $stmt->fetch();
        return new Subscription($row['subscriptionID'], $row['token'], $row['beginDate'], $row['endDate'], $row['userID']);
    }

    public static function getReservationBySubscription(string $subscriptionID)
    {

        
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT *, r.reservationID as realID, r.beginDate as realBegin, r.endDate as realEnd FROM `_Subscription` s JOIN `_Has_for_subscription` h ON s.subscriptionID = h.subscriptionID JOIN _Reservation as r ON h.reservationID = r.reservationID  WHERE s.subscriptionID = " . $subscriptionID .";");
        $reservations = [];

        while ($row = $stmt->fetch()) {
            $housing = HousingService::GetHousingById($row['housingID']);
            $payMethod = PayementMethodService::GetPayementMethodById($row['payMethodID']);
            $client = ClientService::getClientById($row['clientID']);
            
            return new Reservation($row['realID'], $row['realBegin'], $row['realEnd'], $row['serviceCharge'], $row['touristTax'], $row['status'], $row['nbPerson'], $row['r_price_incl'], $housing, $payMethod, $client);
    }

        return $reservations;
    }

}
