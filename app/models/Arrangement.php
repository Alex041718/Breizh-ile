<?php
class Arrangement
{
    private ?int $arrangementID;
    private string $label;

    public function __construct(?int $arrangementID, string $label)
    {
        $this->arrangementID = $arrangementID;
        $this->label = $label;
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

    /**
     * @return int|null
     */
    public function getArrangementID(): ?int
    {
        return $this->arrangementID;
    }

    /**
     * @param int|null $arrangementID
     */
    public function setArrangementID(?int $arrangementID): void
    {
        $this->arrangementID = $arrangementID;
    }

}
?>
