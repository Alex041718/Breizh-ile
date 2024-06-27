<?php

require_once 'Service.php';
require_once __ROOT__.'/models/ApiKey.php';

class ApiKeyService extends Service
{
    public static function CreateApiKey(ApiKey $apiKey): ApiKey
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO _User_APIKey (userID, apiKey, active, superAdmin) VALUES (:userID, :apiKey, :active, :superAdmin)');
        $stmt->execute([
            'userID' => $apiKey->getUserID(),
            'apiKey' => $apiKey->getApiKey(),
            'active' => (int) $apiKey->isActive(),
            'superAdmin' => (int) $apiKey->isSuperAdmin()
        ]);

        return new ApiKey($apiKey->getUserID(), $apiKey->getApiKey(), $apiKey->isActive(), $apiKey->isSuperAdmin());
    }

    public static function GetApiKeyByUserID(int $userID): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _User_APIKey WHERE userID = ' . $userID);
        
        $apiKeys = [];
        while ($row = $stmt->fetch()) {
            $apiKeys[] = new ApiKey($row['userID'], $row['apiKey'], $row['active'], $row['superAdmin']);
        }

        return $apiKeys;
    }

    public static function GetUserIDByApiKey(string $apiKey): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT userID FROM _User_APIKey WHERE apiKey = '" . $apiKey . "'");
        $row = $stmt->fetch();
        return $row['userID'];
    }

    public static function GetApiKeyByApiKey(string $apiKey): ApiKey
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query("SELECT * FROM _User_APIKey WHERE apiKey = '" . $apiKey . "'");
        $row = $stmt->fetch();
        return new ApiKey($row['userID'], $row['apiKey'], $row['active'], $row['superAdmin']);
    }

    public static function changeActive(ApiKey $apiKey): ApiKey
    {
        $newVisibility = (int) !$apiKey->isActive();
        $apiKey->setActive($newVisibility);

        $pdo = self::getPDO();
        $stmt = $pdo->prepare('UPDATE _User_APIKey SET active = ? WHERE apiKey = ?');
        $stmt->execute([$newVisibility, $apiKey->getApiKey()]);

        return $apiKey;
    }
}
?>