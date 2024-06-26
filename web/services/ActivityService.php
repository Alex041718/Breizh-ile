<?php
// imports
require_once 'Service.php';
require_once __ROOT__ . '/models/Activity.php';

class ActivityService extends Service
{
    public static function GetAllActivities()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Activity');
        $activities = [];

        while ($row = $stmt->fetch()) {
            $activities[] = new Activity($row['activityID'], $row['label']);
        }

        return $activities;
    }

    public static function GetActivityById(int $activityID)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Activity WHERE activityID = ' . $activityID);
        $row = $stmt->fetch();

        return new Activity($row['activityID'], $row['label']);
    }

    public static function getAllActivitiesAsArrayOfString()
    {
        $activities = self::GetAllActivities();
        $activitiesStrings = [];

        foreach ($activities as $activity) {
            $activitiesStrings[] = $activity->getLabel();
        }

        return $activitiesStrings;
    }

    public static function GetActivityByHousingId(int $housingId) //: array
    {
        $pdo = self::getPDO();
        // Corrigez la requête SQL pour sélectionner les colonnes souhaitées
        $stmt = $pdo->query('SELECT _Activity.activityID, _Activity.label, _Perimeter.perimeterID, _Perimeter.label AS perimeterLabel 
                         FROM _Has_for_activity 
                         JOIN _Activity ON _Activity.activityID = _Has_for_activity.activityID 
                         JOIN _Perimeter ON _Perimeter.perimeterID = _Has_for_activity.perimeterID 
                         WHERE housingID =' . $housingId);

        $activities = [];

        while ($row = $stmt->fetch()) {
            // Créez une instance de l'activité et ajoutez-la au tableau des activités
            $activities[] = [
                'activityID' => $row['activityID'],
                'activityLabel' => $row['label'],
                'perimeterID' => $row['perimeterID'],
                'perimeterLabel' => $row['perimeterLabel']
            ];
        }

        return $activities;
    }

}
