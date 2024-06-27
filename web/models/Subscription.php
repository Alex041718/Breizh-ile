<?php
require_once 'Client.php';
/**
 *
 */
class Subscription
{
    /**
     * @var int|null
     */
    private ?int $id;
    /**
     * @var string
     */
    private string $token;
     /**
     * @var DateTime
     */
    private DateTime $beginDate;
    /**
     * @var DateTime
     */
    private DateTime $endDate;
    /**
     * @var int
     */
    private int $userID;

    /**
     * @param int|null $id
     * @param string $token
     * @param DateTime $beginDate
     * @param DateTime $endDate
     * @param int $userID
     */
    public function __construct(?int $id, string $token, DateTime $beginDate, DateTime $endDate, int $userID)
    {
        $this->id = $id;
        $this->token = $token;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
        $this->userID = $userID;
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
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return void
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
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
     * @return Client
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @param int $endDate
     * @return void
     */
    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }
}
