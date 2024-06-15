<?php
class HasForArrangement
{
    private int $housingID;
    private int $arrangementID;

    public function __construct(int $housingID, int $arrangementID)
    {
        $this->housingID = $housingID;
        $this->arrangementID = $arrangementID;
    }

    public function getHousingID(): int
    {
        return $this->housingID;
    }

    public function getarrangementID(): int
    {
        return $this->arrangementID;
    }
}