<?php
require_once 'Client.php';
/**
 *
 */
class Reservation
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var DateTime
     */
    private DateTime $creationDate;
    /**
     * @var DateTime
     */
    private DateTime $beginDate;
    /**
     * @var DateTime
     */
    private DateTime $endDate;
    /**
     * @var float
     */
    private float $serviceCharge;
    /**
     * @var float
     */
    private float $touristTax;
    /**
     * @var string
     */
    private string $status;
    /**
     * @var int
     */
    private int $nbPerson;
    /**
     * @float
     */
    private float $priceIncl;
    /**
     * @var Housing
     */
    private Housing $housingId;
    /**
     * @var PayementMethod
     */
    private PayementMethod $payMethodId;
    /**
     * @var Client
     */
    private Client $clientId;

    /**
     * @param int|null $id
     * @param DateTime $beginDate
     * @param DateTime $endDate
     * @param float $serviceCharge
     * @param float $touristTax
     * @param string $status
     * @param Housing $housingId
     * @param PayementMethod $payMethodId
     * @param Client $clientId
     */
    public function __construct(?int $id, DateTime $creationDate, DateTime $beginDate, DateTime $endDate, float $serviceCharge, float $touristTax, string $status, int $nbPerson, float $priceIncl, Housing $housingId, PayementMethod $payMethodId, Client $clientId)
    {
        $this->id = $id;
        $this->creationDate = $creationDate;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
        $this->serviceCharge = $serviceCharge;
        $this->touristTax = $touristTax;
        $this->status = $status;
        $this->nbPerson = $nbPerson;
        $this->priceIncl = $priceIncl;
        $this->housingId = $housingId;
        $this->payMethodId = $payMethodId;
        $this->clientId = $clientId;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * @return DateTime
     */
    public function getBeginDate(): DateTime
    {
        return $this->beginDate;
    }

    /**
     * @param DateTime $beginDate
     * @return void
     */
    public function setBeginDate(DateTime $beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     * @return void
     */
    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return float
     */
    public function getServiceCharge(): float
    {
        return $this->serviceCharge;
    }

    /**
     * @param float $serviceCharge
     * @return void
     */
    public function setServiceCharge(float $serviceCharge): void
    {
        $this->serviceCharge = $serviceCharge;
    }

    /**
     * @return float
     */
    public function getTouristTax(): float
    {
        return $this->touristTax;
    }

    /**
     * @param float $touristTax
     * @return void
     */
    public function setTouristTax(float $touristTax): void
    {
        $this->touristTax = $touristTax;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getNbPerson(): int
    {
        return $this->nbPerson;
    }

    /**
     * @return float
     */
    public function getPriceIncl(): float
    {
        return $this->priceIncl;
    }

    /**
     * @return Housing
     */
    public function getHousingId(): Housing
    {
        return $this->housingId;
    }

    /**
     * @param Housing $housingId
     * @return void
     */
    public function setHousingId(Housing $housingId): void
    {
        $this->housingId = $housingId;
    }

    /**
     * @return PayementMethod
     */
    public function getPayMethodId(): PayementMethod
    {
        return $this->payMethodId;
    }

    /**
     * @param PayementMethod $payMethodId
     * @return void
     */
    public function setPayMethodId(PayementMethod $payMethodId): void
    {
        $this->payMethodId = $payMethodId;
    }

    /**
     * @return Client
     */
    public function getClientId(): Client
    {
        return $this->clientId;
    }
}