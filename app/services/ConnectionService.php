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
}
?>
