<?php
class Service
{
    private ?int $serviceID;
    private string $label;

    public function __construct(?int $serviceID, string $label)
    {
        $this->serviceID = $serviceID;
        $this->label = $label;
    }

    /**
     * @return int|null
     */
    public function getServiceID(): ?int
    {
        return $this->serviceID;
    }

    /**
     * @param int|null $serviceID
     */
    public function setServiceID(?int $serviceID): void
    {
        $this->serviceID = $serviceID;
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
