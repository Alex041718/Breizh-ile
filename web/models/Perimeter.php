<?php
class Perimeter
{
    private ?int $perimeterID;
    private string $label;

    public function __construct(?int $perimeterID, string $label)
    {
        $this->perimeterID = $perimeterID;
        $this->label = $label;
    }

    /**
     * @return int|null
     */
    public function getPerimeterID(): ?int
    {
        return $this->perimeterID;
    }

    /**
     * @param int|null $perimeterID
     */
    public function setPerimeterID(?int $perimeterID): void
    {
        $this->perimeterID = $perimeterID;
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