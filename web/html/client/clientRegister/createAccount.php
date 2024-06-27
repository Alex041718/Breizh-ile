<?php
require_once ('../../../services/ClientService.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $client = unserialize( base64_decode( $_COOKIE['account']));
    $inputCode = $_POST["inputCode"];
    $realCode = unserialize( base64_decode( $_COOKIE['token']));

    if(!$client || !$realCode) header("Location: /client/register?error=La%20session%20a%20expirée%20,%20veuillez%20réessayer.");
    
    if($realCode === $inputCode) {
        ClientService::CreateClient($client);
        setcookie('token', '', -1, '/'); 
        setcookie('account', '', -1, '/'); 
        header("Location: /client/register?success=true");
    }
    else {
        header("Location: /client/register?error=Code%20incorrect.");
    }
}