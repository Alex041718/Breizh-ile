<?php

// la class Bid (devis d'une réservation de logement)

class Bid {
    private int $numberPerson;
    private DateTime $beginDate;
    private DateTime $endDate;
    private bool $isValidated;
    private int $interval;
    private Housing $housing;
    private ?Client $client;
    private Owner $owner;

    public function __construct(int $numberPerson, DateTime $beginDate, DateTime $endDate, bool $isValidated, int $interval, Housing $housing, ?Client $client, Owner $owner)
    {
        $this->numberPerson = $numberPerson;
        $this->beginDate = $beginDate;
        $this->endDate = $endDate;
        $this->isValidated = $isValidated;
        $this->interval = $interval;
        $this->housing = $housing;
        $this->client = $client;
        $this->owner = $owner;
    }

    public function getNumberPerson(): int
    {
        return $this->numberPerson;
    }

    public function setNumberPerson(int $numberPerson): void
    {
        $this->numberPerson = $numberPerson;
    }

    public function getBeginDate(): DateTime
    {
        return $this->beginDate;
    }

    public function setBeginDate(DateTime $beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function isValidated(): bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(bool $isValidated): void
    {
        $this->isValidated = $isValidated;
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    public function setInterval(int $interval): void
    {
        $this->interval = $interval;
    }

    public function getHousing(): Housing
    {
        return $this->housing;
    }

    public function setHousing(Housing $housing): void
    {
        $this->housing = $housing;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

    public function setOwner(Owner $owner): void
    {
        $this->owner = $owner;
    }



}
