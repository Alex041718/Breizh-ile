<?php
// imports
require_once 'Service.php';
class ConnectionService extends Service
{

    public static function CheckAdmin(string $nickname, string $password): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM _Admin WHERE nickname = :nickname');
        $stmt->execute([
            'nickname' => $nickname
        ]);
        $admin = $stmt->fetch();
        if (!$admin) {
            return false;
        }
        return password_verify($password, $admin['password']);
    }

    public static function GetAdminID(string $nickname): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT adminID FROM _Admin WHERE nickname = :nickname');
        $stmt->execute([
            'nickname' => $nickname
        ]);

        $admin = $stmt->fetch();
        return $admin['adminID'];
    }

    public static function CheckClient(string $mail, string $password): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM Client WHERE mail = :mail');
        $stmt->execute([
            'mail' => $mail
        ]);
        $client = $stmt->fetch();
        if (!$client) {
            return false;
        }
        return password_verify($password, $client['password']);
    }

    public static function GetClientID(string $mail): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT clientID FROM Client WHERE mail = :mail');
        $stmt->execute([
            'mail' => $mail
        ]);
        $client = $stmt->fetch();

        return $client['clientID'];
    }

    public static function CheckOwner(string $mail, string $password): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM Owner WHERE mail = :mail');
        $stmt->execute([
            'mail' => $mail
        ]);
        $owner = $stmt->fetch();
        // le cas où on a pas trouvé le propriétaire
        if (!$owner) {
            return false;
        }
        return password_verify($password, $owner['password']);
    }

    public static function GetOwnerID(string $mail): int
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT ownerID FROM Owner WHERE mail = :mail');
        $stmt->execute([
            'mail' => $mail
        ]);
        $owner = $stmt->fetch();
        return $owner['ownerID'];
    }
}
?>
