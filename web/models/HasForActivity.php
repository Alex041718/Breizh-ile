<?php
class HasForActivity
{
    private int $housingID;
    private int $activityID;
    private int $perimeterID;

    public function __construct(int $housingID, int $activityID, int $perimeterID)
    {
        $this->housingID = $housingID;
        $this->activityID = $activityID;
        $this->perimeterID = $perimeterID;
    }

    public function getHousingID(): int
    {
        return $this->housingID;
    }

    public function getActivityID(): int
    {
        return $this->activityID;
    }

    public function getPerimeterID(): int
    {
        return $this->perimeterID;
    }
}