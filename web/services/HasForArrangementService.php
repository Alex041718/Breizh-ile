<?php
// imports
require_once 'Service.php';
require_once __ROOT__.'/models/HasForArrangement.php';

class HasForArrangementService extends Service
{
    public static function CreateHasForArrangement(HasForArrangement $hasForArrangement): HasForArrangement 
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Has_for_arrangement (housingID, arrangementID) VALUES (:housingID, :arrangementID)');
        $stmt->execute([
            'housingID' => $hasForArrangement->getHousingID(),
            'arrangementID' => $hasForArrangement->getArrangementID()
        ]);

        return new HasForArrangement($hasForArrangement->getHousingID(), $hasForArrangement->getArrangementID());
    }
}