<?php
// URL de l'endpoint
$url = 'http://localhost:8080/api/endpoint';

// Données à envoyer
$data = array(
    'key1' => 'value1',
    'key2' => 'value2'
);
$data_json = json_encode($data);

// Création de la requête
$options = array(
    'http' => array(
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => $data_json
    )
);
$context = stream_context_create($options);

// Envoi de la requête
$result = file_get_contents($url, false, $context);

// Vérification des erreurs
if ($result === false) {
    echo 'Erreur lors de la requête';
} else {
    echo 'Réponse du serveur: ' . $result;
}
?>