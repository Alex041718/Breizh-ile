<?php

require_once "../../../services/ApiKeyService.php";
require_once "../../components/Popup/popup.php";

session_start();

function random_api_key($length) {
    $bytes = "";
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    for ($i = 0; $i < $length; $i++) {
        $bytes .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $bytes;
}

ApiKeyService::CreateApiKey(new ApiKey($_SESSION["user_id"], random_api_key(64), true, false));
?>