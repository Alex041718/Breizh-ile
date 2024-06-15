<?php

error_log("Bienvenue sur le script de migrations !");
error_log("Ces logs visibles dans la console du container de migrations 'breizh-ile_migration-sql'");


$host = 'db';  // Nom d'hôte du service de base de données
$dbname = 'db';
$user = 'root';
$password = 'root';
$retryMax = 10;
$retryDelay = 5;
$charset = 'utf8mb4';



$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

while ($retryMax > 0) {
    error_log("Tentative de connexion à la base de données...");
    try {
        $pdo = new PDO($dsn, $user, $password, $options);
        echo "Connecté à la base de données avec succès.";
        error_log("Connecté à la base de données avec succès.");
        break;
    } catch (\PDOException $e) {
        $retryMax--;
        sleep($retryDelay);
        //throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

// Parcourir les fichiers de migration

// les fichiers de migration vont s'intituler de la manière suivante : 290420241900-_User-ajout-colonne-animal-fav.sql
// Une date au debut puis une description de la migration

$migrationFiles = array_diff(scandir(__DIR__ . '/migrations'), array('..', '.'));
echo "<pre>";
echo "Fichiers de migration trouvés : \n";
print_r($migrationFiles);
echo "</pre>";

$migrationsCompleted = $pdo->query('SELECT scriptName FROM db._Migration')->fetchAll(PDO::FETCH_COLUMN);
print_r($migrationsCompleted);
$newMigrations = array_diff($migrationFiles, $migrationsCompleted);
sort($newMigrations);

// Exécuter les migrations non appliquées

foreach ($newMigrations as $migration) {
    $sql = file_get_contents(__DIR__ . "/migrations/$migration");
    try {
        $pdo->beginTransaction();
        $pdo->exec($sql);
        $stmt = $pdo->prepare("INSERT INTO db._Migration (scriptName) VALUES (:scriptName)");
        $stmt->execute(['scriptName' => $migration]);
        $pdo->commit();
        echo "Migration appliquée : $migration\n";
    } catch (\PDOException $e) {
        $pdo->rollBack();
        echo "Erreur lors de l'application de la migration $migration : " . $e->getMessage() . "\n";
    }
}

?>
