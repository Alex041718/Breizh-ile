<?php
// imports
require_once __ROOT__."/models/Arrangement.php";
require_once __ROOT__."/services/Service.php";
class ArrangementService extends Service {

    public static function GetArrangementById(int $arrangementID): Arrangement
    {
        // la méthode réccupère un arrangement par son ID, méthode assez géneraliste
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Arrangement WHERE arrangementID = ' . $arrangementID);
        $row = $stmt->fetch();
        return new Arrangement($row['arrangementID'], $row['label']);
    }

    public static function GetArrangements(): array
    {
        // la méthode réccupère tous les arrangements
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Arrangement');
        $arrangements = [];
        while ($row = $stmt->fetch()) {
            $arrangements[] = new Arrangement($row['arrangementID'], $row['label']);
        }
        return $arrangements;
    }

    public static function GetArrangmentsByHousingId(int $housingID): array
    {
        // la méthode réccupère tous les arrangements d'un logement
        // Grace à la table _Has_for_Arrangement qui fait le lien entre les arrangements et les logements
        // Etape 1 : réccupérer les arrangementsID de la table _Has_for_Arrangement par rapport à l'ID du logement

        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM _Has_for_arrangement WHERE housingID = ' . $housingID);
        $arrangementsID = [];

        while ($row = $stmt->fetch()) {
            $arrangementsID[] = $row['arrangementID'];
        }

        // Etape 2 : réccupérer les arrangements par rapport aux arrangementsID
        $arrangements = [];
        foreach ($arrangementsID as $arrangementID) {
            $arrangements[] = self::GetArrangementById($arrangementID);
        }

        return $arrangements;
    }
}
?>
