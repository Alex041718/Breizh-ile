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
        $row = $stmt->fetch();
        
        $apiKeys = [];
        while ($row = $stmt->fetch()) {
            $apiKeys[] = new ApiKey($row['userID'], $row['apiKey'], $row['active'], $row['superAdmin']);
        }

        return $apiKeys;
    }
}
?>