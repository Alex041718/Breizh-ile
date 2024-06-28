<?php


// le client est redirigé sur ce controlleur pour être déconnecté
require_once '../../services/SessionService.php';

SessionService::logout();

$redirect = $_GET['redirect'] ?? '/';
// décode l'url
$redirect = urldecode($redirect);




header('Location: '. $redirect);
exit();

?>
