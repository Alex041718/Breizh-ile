<?php
// imports
require_once 'Service.php';
require_once __ROOT__.'/models/HasForActivity.php';

class HasForActivityService extends Service
{
    public static function CreateHasForActivity(HasForActivity $hasForActivity): HasForActivity
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _Has_for_activity (housingID, activityID, perimeterID) VALUES (:housingID, :activityID, :perimeterID)');
        $stmt->execute([
            'housingID' => $hasForActivity->getHousingID(),
            'activityID' => $hasForActivity->getActivityID(),
            'perimeterID' => $hasForActivity->getPerimeterID()
        ]);

        return new HasForActivity($hasForActivity->getHousingID(), $hasForActivity->getActivityID(), $hasForActivity->getPerimeterID());
    }
}
