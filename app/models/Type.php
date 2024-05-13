<?php

class Type
{
    private ?int $typeID;
    private string $label;

    public function __construct(?int $typeID, string $label)
    {
        $this->typeID = $typeID;
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
     * @return int
     */
    public function getTypeID(): int
    {
        return $this->typeID;
    }

    /**
     * @param int $typeID
     */
    public function setTypeID(int $typeID): void
    {
        $this->typeID = $typeID;
    }

}
