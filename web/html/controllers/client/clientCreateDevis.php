<?php

// Controller création d'un devis et redirection sur la page de devis


// Supression de potentiel devis existant
require_once('../../../services/SessionService.php');

SessionService::remove('currentBid');
function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

$oldPage = $_POST['oldPage'] ?? '/logement/?housingID=' . $_POST['housingID'];

// verrification de la méthode de la requête et l'existence des données
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['startDate']) || !isset($_POST['endDate']) || !isset($_POST['numberPerson']) || !isset($_POST['housingID']) || !isset($_POST['ownerID'])) {
    redirect($oldPage);
}

if ($_POST['startDate'] == "" || $_POST['endDate'] == "" || $_POST['numberPerson'] == "" || $_POST['housingID'] == "" || $_POST['ownerID'] == "") {
    redirect($oldPage);
}


// Récupération des données du formulaire

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$numberPerson = $_POST['numberPerson'];
if (isset($_POST['isAuthenticated']) && $_POST['isAuthenticated'] === '1') {
    $isAuthenticated = true;
    if(isset($_POST['clientID']))
        $clientID = $_POST['clientID'];
    else
        $clientID = -1;
} else {
    $isAuthenticated = false;
    $clientID = -1;
}


$housingID = $_POST['housingID'];
$ownerID = $_POST['ownerID'];


// Création du devis

// Calcul du nombre de jours de location
$startDate = new DateTime($startDate);
$endDate = new DateTime($endDate);
$interval = $startDate->diff($endDate);
$days = $interval->days;


// Réccupération des informations du logement et du client et du propriétaire

require_once '../../../services/HousingService.php';
require_once '../../../services/ClientService.php';
require_once '../../../services/OwnerService.php';
$housing = HousingService::getHousingByID($housingID);
if ($isAuthenticated && $clientID !== -1)
    $client = ClientService::getClientByID($clientID);
else
    $client = null;
$owner = OwnerService::getOwnerByID($ownerID);

// Création du devis

require_once '../../../models/Bid.php';

$bid = new Bid($numberPerson, $startDate, $endDate, false, $days, $housing, $client, $owner);

$resToSend = [
    'numberPerson' => $numberPerson,
    'beginDate' => $startDate,
    'endDate' => $endDate,
    'isPaid' => false,
    'interval' => $days,
    'housing' => $housing->getHousingID(),
    'client' => $isAuthenticated ? $client->getClientID() : null,
    'owner' => $owner->getOwnerID()
];



// Transmission du devis à la page de devis via la session





SessionService::set('oldPage', $oldPage);

SessionService::set('currentBid', $resToSend);

// Redirection vers la page de devis

//var_dump($resToSend);




redirect('/logement/devis');



?>
