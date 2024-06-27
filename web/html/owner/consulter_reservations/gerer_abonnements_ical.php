<?php
require_once '../../../services/SessionService.php';
SessionService::system('owner', '/back/reservations');

$isOwnerAuthenticated = SessionService::isOwnerAuthenticated();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des abonnements iCal</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/components/Toast/Toast.css">
    <script src="gerer_abonnements.js"></script>
    <link rel="stylesheet" href="gerer_abonnements.css"> <!-- CSS spécifique à cette page -->
</head>
<body>
    <?php
        // Assurez-vous que le chemin vers OwnerService.php est correct
        require_once '../../../services/SessionService.php';
        require_once '../../../services/OwnerService.php'; // Ajout de cette ligne pour inclure OwnerService
        require_once("../../components/Header/header.php");
        require_once("../../components/OwnerNavBar/ownerNavBar.php");
        require_once("../../../services/ReservationService.php");

        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //     $isOwnerAuthenticated = SessionService::isOwnerAuthenticated();
        
        //     if (!$isOwnerAuthenticated) {
        //         echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        //         exit();
        //     }
        
        //     $owner = OwnerService::GetOwnerById($_SESSION['user_id']);
        //     $ownerId = $owner->getOwnerID();
        //     $reservations = $_POST['reservations'];
        //     $startDate = $_POST['startDate'];
        //     $endDate = $_POST['endDate'];
        
        //     if (empty($reservations) || empty($startDate) || empty($endDate)) {
        //         echo json_encode(['success' => false, 'message' => 'Invalid input']);
        //         exit();
        //     }
        
        //     // Assuming you have a function to generate a unique token
        //     $token = generateUniqueToken();
        
        //     // Save the subscription details to the database (implement this function)
        //     saveSubscription($ownerId, $token, $startDate, $endDate, $reservations);
        
        //     $url = "https://owner/consulter_reservations/generate_ical.php?token=$token";
        //     echo json_encode(['success' => true, 'url' => $url]);
        // }
        
        // function generateUniqueToken() {
        //     return bin2hex(random_bytes(16));
        // }
        
        // // function saveSubscription($ownerId, $token, $startDate, $endDate, $reservations) {
        // //     // Implement the logic to save the subscription details to the database
        // //     // Example:
        // //     // INSERT INTO subscriptions (owner_id, token, start_date, end_date, reservations) VALUES (?, ?, ?, ?, ?)
        // // }
    ?>
    <main>
        <h3>Gérer vos abonnements iCal</h3>
        <!-- Section pour générer l'URL d'abonnement -->
        <section class="generate-subscription">
            <h4>Réservations en cours</h4>
            <section class="title">
                <?php
                    require_once("../../components/CheckBox/CheckBox.php");
                    CheckBox::render(name: "checkboxAll");
                ?>
                <p data-sort="date-resa">Date de réservation</p>
                <p data-sort="client">Client</p>
                <p data-sort="logement">Logement</p>
                <p data-sort="date-arrivee">Date d'arrivée</p>
                <p data-sort="date-depart">Date de départ</p>
                <p data-sort="methode-paiement">Méthode de paiement</p>
                <p data-sort="status">Status</p>
                <button class="filter"><i class="fa-solid fa-filter"></i></button>
            </section>
            <div id="page">
                <section class="reservations"></section>

                <div class="infoUrl">
                    <h4>Générer une nouvelle URL d'abonnements</h4>
                    <form id="generate-subscription-form" action="generer_abonnement.php" method="POST">
                        <div class="date">
                            <div class="debut">
                                <label for="start-date">Date de début :</label>
                                <input type="date" id="start-date" name="start-date" required>
                            </div>
                            <div class="fin">
                                <label for="end-date">Date de fin :</label>
                                <input type="date" id="end-date" name="end-date" required>
                            </div>
                        </div>
                        <button type="submit" id="generate-url-button">Générer URL</button>
                    </form>

                    <div class="subscription-url" style="display: none;">
                        <label for="subscription-url">URL d'abonnement :</label>
                        <input type="text" id="subscription-url" readonly>
                        <button id="copy-button">Copier</button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section pour afficher les abonnements existants -->
        <section class="subscriptions">
            <h4>Vos abonnements</h4>
            <ul id="subscriptions-list">
                <!-- Les abonnements existants seront affichés ici -->
                <?php
                function getSubscriptions($userId) {
                    // Récupérer les abonnements de l'utilisateur depuis la base de données
                    // Ex: SELECT * FROM subscriptions WHERE user_id = ...
                    return [
                        [
                            'token' => 'abcd1234',
                            'start_date' => '2023-07-01',
                            'end_date' => '2023-12-31',
                            'properties' => ['Bien 1', 'Bien 2']
                        ]
                    ];
                }

                $userId = $_SESSION['user_id'];
                $subscriptions = getSubscriptions($userId);
                foreach ($subscriptions as $subscription) {
                    echo '<li>';
                    echo '<p>Token : ' . $subscription['token'] . '</p>';
                    echo '<p>Période : ' . $subscription['start_date'] . ' - ' . $subscription['end_date'] . '</p>';
                    echo '<p>Biens : ' . implode(", ", $subscription['properties']) . '</p>';
                    echo '<button onclick="copyToClipboard(\'https://owner/consulter_reservations/ical.php?token=' . $subscription['token'] . '\')">Copier URL</button>';
                    echo '<button onclick="deleteSubscription(\'' . $subscription['token'] . '\')">Supprimer</button>';
                    echo '</li>';
                }
                ?>
            </ul>
        </section>
    </main>

</body>
</html>
