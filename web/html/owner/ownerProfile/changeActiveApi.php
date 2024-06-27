<?php
require_once("../../../services/ApiKeyService.php");
session_start();

$apiKey_form = $_POST['apiKey'];
$apiKey = ApiKeyService::GetApiKeyByApiKey($apiKey_form);

if ($apiKey->getUserID() == $_SESSION['user_id']) {
    ApiKeyService::changeActive($apiKey);
}
?>