<?php

class Category
{
    private ?int $categoryID; // l'id peut être null puisse que c'est la base de données qui s'en charge
    private string $label;

    public function __construct(?int $categoryID, string $label)
    {
        $this->categoryID = $categoryID;
        $this->label = $label;
    }

    /**
     * @return int
     */
    public function getCategoryID(): int
    {
        return $this->categoryID;
    }

    /**
     * @param int $categoryID
     */
    public function setCategoryID(?int $categoryID): void
    {
        $this->categoryID = $categoryID;
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
