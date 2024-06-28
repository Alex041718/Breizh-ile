<?php
require_once '../../../services/SessionService.php';
SessionService::system('client', '/');

$isClientAuthenticated = SessionService::isClientAuthenticated();

if(!$isClientAuthenticated) header("Location: /");

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
    <script src="/client/consulter_reservations/gerer_abonnements.js"></script>
    <link rel="stylesheet" href="/client/consulter_reservations/gerer_abonnements.css"> <!-- CSS spécifique à cette page -->
</head>
<body>
    <?php
        // Assurez-vous que le chemin vers OwnerService.php est correct
        require_once '../../../services/SessionService.php';
        require_once '../../../services/ClientService.php'; // Ajout de cette ligne pour inclure OwnerService
        require_once("../../components/Header/header.php");
        require_once("../../../services/ReservationService.php");
        require_once("../../../services/SubscriptionService.php");

        if(isset($_GET['token'])) $url = "http://" . $_SERVER['HTTP_HOST'] . "/client/consulter_reservations/iCal.php?token=" . $_GET['token'];
        else $url = "";

        Header::render(True, false, $isClientAuthenticated, '/back/reservations');
        
        $client = ClientService::GetClientById($_SESSION['user_id']);

        $reservations = ReservationService::getAllReservationsByClientID($client->getClientID());
        $_SESSION["reservations"] = $reservations;

    ?>

    <main>
        <h3>Gérer vos abonnements iCal</h3>
        <!-- Section pour générer l'URL d'abonnement -->
        <section class="generate-subscription">
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
                    <h4><?= isset($_GET['editMode']) && $_GET['editMode'] === "enable" ? "Modifier l'abonnement" : "Générer une nouvelle URL d'abonnements" ?></h4>
                    <?= isset($_GET["error"]) && $_GET["error"] != "" ? '<p class="error">' . $_GET["error"] . '</p>' : "" ?>
                    <form id="generate-subscription-form" action="<?= isset($_GET['editMode']) && $_GET['editMode'] === "enable" ? "/client/consulter_reservations/modifier_abonnement.php" : "/client/consulter_reservations/generer_abonnement.php" ?>" method="POST">
                        <div class="date">
                            <?= isset($_GET['editMode']) && $_GET['editMode'] === "enable" && isset($_GET['token']) && $_GET['token'] !== "" ? '<input type="hidden" name="token" value="' . $_GET['token'] . '">' : "" ?>
                            <div class="debut">
                                <label for="start-date">Date de début :</label>
                                <input type="date" id="start-date" name="start-date" required>
                            </div>
                            <div class="fin">
                                <label for="end-date">Date de fin :</label>
                                <input type="date" id="end-date" name="end-date" required>
                            </div>
                        </div>
                        <button type="submit" id="generate-url-button"><?= isset($_GET['editMode']) && $_GET['editMode'] === "enable" ? "Modifier" : "Générer l'URL" ?></button>
                    </form>

                    <?php $editMode = isset($_GET['editMode']) && $_GET['editMode'] === "enable";
                    $isToken = isset($_GET['token']) && $_GET['token'] !== "";
                    echo ($isToken && $editMode) || ( $isToken && !$editMode ) || ( !$isToken && $editMode ) ?

                    '<div class="subscription-url">
                        <label for="subscription-url">URL d\'abonnement :</label>
                        <input type="text" id="subscription-url" value="' . $url . '" readonly>
                        <button id="copy-button">Copier</button>
                    </div>' : "" ?>
                </div>
            </div>
        </section>

        <?php 
            $userId = $_SESSION['user_id'];
            $subscriptions = SubscriptionService::getSubscriptionsByUserID($userId);
            if(!$subscriptions) return;
        ?>
        <section class="subscriptions">
            <h4>Vos abonnements</h4>
            <ul id="subscriptions-list">
                <?php
                foreach ($subscriptions as $index => $subscription) { 
                    $isEditMode = isset($_GET['editMode']) && $_GET['editMode'] == "enable"; ?>
                    <li class="row <?= $isEditMode && isset($_GET['token']) && $_GET['token'] == $subscription->getToken() ? "row--selected" : "" ?>">
                        <i class="open-eye fa-solid fa-eye"></i>
                        <i class="closed-eye fa-solid fa-eye-slash"></i>
                        <p class="token"><?= $subscription->getToken() ?></p>
                        <p class="period">Période : <?= $subscription->getBeginDate()->format("d/m/Y") . ' - ' . $subscription->getEndDate()->format("d/m/Y") ?></p>
                        <div class="buttons">
                            <button onclick="navigator.clipboard.writeText(' <?= "http://" . $_SERVER['HTTP_HOST'] . "/client/consulter_reservations/ical.php?token=" . $subscription->getToken() ?> ');alert('URL copiée dans le presse-papiers !');">Copier URL</button>
                            <button id="modify" onclick="modifySubscribe('<?= $subscription->getToken() ?>', <?= (int)$isEditMode ?>)"><?= $isEditMode && isset($_GET['token']) && $_GET['token'] == $subscription->getToken() ? "Annuler" : "Modifier" ?></button>
                            <button id="delete" <?= $isEditMode && isset($_GET['token']) && $_GET['token'] == $subscription->getToken() ? "disabled" : "" ?> onclick="deleteSubscribe('<?= $subscription->getToken() ?>', <?= $index ?>)">Supprimer</button>
                        </div>
                    </li>
                <?php }
                ?>
            </ul>
        </section>
    </main>

</body>
</html>
