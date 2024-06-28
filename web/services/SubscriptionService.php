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
            'beginDate' => $subscription->getBeginDate()->format("Y-m-d"),
            'endDate' => $subscription->getEndDate()->format("Y-m-d"),
            'userID' => $subscription->getUserID(),
        ));

        $current_id = $pdo->lastInsertId();
        
        foreach ($reservations as $reservation) {
            $stmt = $pdo->prepare('INSERT INTO _Has_for_subscription (subscriptionID , reservationID ) VALUES (:subscriptionID, :reservationID);');

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
        if($row) return new Subscription($row['subscriptionID'], $row['token'], new DateTime($row['beginDate']), new DateTime($row['endDate']), $row['userID']);
        else return false;
    }

    public static function deleteSubscriptionByToken(Subscription $subscription)
    {

        $pdo = self::getPDO();
        $stmt = $pdo->query("DELETE FROM _Has_for_subscription WHERE subscriptionID = '" . $subscription->getId() . "';");
        $stmt->execute();

        $pdo = self::getPDO();
        $stmt = $pdo->query("DELETE FROM _Subscription WHERE token = '" . $subscription->getToken() . "';");
        $stmt->execute();
    }

    public static function getSubscriptionsByUserID(string $userID)
    {
        $reservations = [];

        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM _Subscription WHERE userID = '" . $userID . "';");

        while ($row = $stmt->fetch()) {
            $reservations[] = new Subscription($row['subscriptionID'], $row['token'], new DateTime($row['beginDate']), new DateTime($row['endDate']), $row['userID']);
        }

        return $reservations;
    }

    public static function getReservationBySubscription(string $subscriptionID)
    {

        
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT *, r.reservationID as realID, r.beginDate as realBegin, r.endDate as realEnd FROM `_Subscription` s JOIN `_Has_for_subscription` h ON s.subscriptionID = h.subscriptionID JOIN _Reservation as r ON h.reservationID = r.reservationID  WHERE s.subscriptionID = " . $subscriptionID ." AND r.beginDate >= s.beginDate AND r.endDate <= s.endDate;");
        $reservations = [];

        while ($row = $stmt->fetch()) {
            $housing = HousingService::GetHousingById($row['housingID']);
            $payMethod = PayementMethodService::GetPayementMethodById($row['payMethodID']);
            $client = ClientService::getClientById($row['clientID']);
            
            $reservations[] = new Reservation($row['realID'], new DateTime($row['realBegin']), new DateTime($row['realEnd']), $row['serviceCharge'], $row['touristTax'], $row['status'], $row['nbPerson'], $row['priceIncl'], $housing, $payMethod, $client);
        }

        return $reservations;
    }

}
