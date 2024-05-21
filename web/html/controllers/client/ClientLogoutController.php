<?php


// le client est redirigé sur ce controlleur pour être déconnecté
require_once '../../../services/SessionService.php';

SessionService::logout();

header('Location: /');
exit();

?>
