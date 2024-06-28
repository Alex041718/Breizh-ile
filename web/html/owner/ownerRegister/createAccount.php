<?php
require_once ('../../../services/OwnerService.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $owner = unserialize( base64_decode( $_COOKIE['accountOwner']));
    $inputCode = $_POST["inputCode"];
    $realCode = unserialize( base64_decode( $_COOKIE['tokenOwner']));

    if(!$owner || !$realCode) header("Location: /back/register?error=La%20session%20a%20expirée%20,%20veuillez%20réessayer.");
    
    if($realCode === $inputCode) {
        OwnerService::CreateOwner($owner);
        setcookie('tokenOwner', '', -1, '/'); 
        setcookie('accountOwner', '', -1, '/'); 
        header("Location: /back/register?success=true");
    }
    else {
        header("Location: /back/register?error=Code%20incorrect.");
    }
}