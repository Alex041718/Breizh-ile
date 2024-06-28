<?php

require_once 'Reservation.php';
require_once 'Client.php';
require_once 'PayementMethod.php';

class Receipt
{
    private ?int $receiptID;
    private Reservation $reservation;
    private DateTime $receiptDate;
    private float $touristTax;
    private float $totalHT;
    private float $totalTVA;
    private float $totalTTC;
    private float $TVA;
    private ?DateTime $paymentDate;
    private PayementMethod $payMethod;
    private Client $client;

    public function __construct(?int $receiptID, Reservation $reservation, DateTime $receiptDate, float $touristTax, float $totalHT, float $totalTVA, float $totalTTC, float $TVA, ?DateTime $paymentDate, PayementMethod $payMethod, Client $client)
    {
        $this->receiptID = $receiptID;
        $this->reservation = $reservation;
        $this->receiptDate = $receiptDate;
        $this->touristTax = $touristTax;
        $this->totalHT = $totalHT;
        $this->totalTVA = $totalTVA;
        $this->totalTTC = $totalTTC;
        $this->TVA = $TVA;
        $this->paymentDate = $paymentDate;
        $this->payMethod = $payMethod;
        $this->client = $client;
    }

    // Getters and setters for each property go here
    // For example:
    public function getReceiptID(): ?int
    {
        return $this->receiptID;
    }

    public function setReceiptID(?int $receiptID): void
    {
        $this->receiptID = $receiptID;
    }

        public function getReservation(): Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): void
    {
        $this->reservation = $reservation;
    }

    public function getReceiptDate(): DateTime
    {
        return $this->receiptDate;
    }

    public function setReceiptDate(DateTime $receiptDate): void
    {
        $this->receiptDate = $receiptDate;
    }

    public function getTouristTax(): float
    {
        return $this->touristTax;
    }

    public function setTouristTax(float $touristTax): void
    {
        $this->touristTax = $touristTax;
    }

    public function getTotalHT(): float
    {
        return $this->totalHT;
    }

    public function setTotalHT(float $totalHT): void
    {
        $this->totalHT = $totalHT;
    }

    public function getTotalTVA(): float
    {
        return $this->totalTVA;
    }

    public function setTotalTVA(float $totalTVA): void
    {
        $this->totalTVA = $totalTVA;
    }

    public function getTotalTTC(): float
    {
        return $this->totalTTC;
    }

    public function setTotalTTC(float $totalTTC): void
    {
        $this->totalTTC = $totalTTC;
    }

    public function getTVA(): float
    {
        return $this->TVA;
    }

    public function setTVA(float $TVA): void
    {
        $this->TVA = $TVA;
    }

    public function getPaymentDate(): ?DateTime
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?DateTime $paymentDate): void
    {
        $this->paymentDate = $paymentDate;
    }

    public function getPayMethod(): PayementMethod
    {
        return $this->payMethod;
    }

    public function setPayMethod(PayementMethod $payMethod): void
    {
        $this->payMethod = $payMethod;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}