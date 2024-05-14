<?php

/**
 *
 */
class PayementMethod
{
    /**
     * @var int|null
     */
    private ?int $payMethodId;
    /**
     * @var string
     */
    private string $label;

    /**
     * @param int|null $payMethodId
     * @param string $label
     */
    public function __construct(?int $payMethodId, string $label)
    {
        $this->payMethodId  = $payMethodId;
        $this->label        = $label;
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
     * @return void
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return int|null
     */
    public function getPayMethodId(): ?int
    {
        return $this->payMethodId;
    }

    /**
     * @param int|null $payMethodId
     * @return void
     */
    public function setPayMethodId(?int $payMethodId): void
    {
        $this->payMethodId = $payMethodId;
    }

}