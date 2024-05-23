<?php
// imports
require_once 'Service.php';
require_once __ROOT__.'/models/Activity.php';

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
}
