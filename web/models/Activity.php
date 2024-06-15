<?php
class Activity
{
    private ?int $activityID;
    private string $label;

    public function __construct(?int $activityID, string $label)
    {
        $this->activityID = $activityID;
        $this->label = $label;
    }

    /**
     * @return int|null
     */
    public function getActivityID(): ?int
    {
        return $this->activityID;
    }

    /**
     * @param int|null $activityID
     */
    public function setActivityID(?int $activityID): void
    {
        $this->activityID = $activityID;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }
}