<?php

class ApiKey
{
    private int $userID;
    private string $apiKey;
    private bool $active;
    private bool $superAdmin;

    public function __construct(int $userID, string $apiKey, bool $active, bool $superAdmin)
    {
        $this->userID = $userID;
        $this->apiKey = $apiKey;
        $this->active = $active;
        $this->superAdmin = $superAdmin;
    }

    /**
     * @return int
     */
    public function getUserID(): int
    {
        return $this->userID;
    }

    /**
     * @param int $userID
     */
    public function setUserID(int $userID): void
    {
        $this->userID = $userID;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->superAdmin;
    }

    /**
     * @param bool $superAdmin
     */
    public function setSuperAdmin(bool $superAdmin): void
    {
        $this->superAdmin = $superAdmin;
    }
}