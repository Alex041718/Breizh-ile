<?php
// Chemin absolu vers le répertoire /uploads
$uploadsDir = '/var/www/uploads';

// Vérifiez que le paramètre 'img' est présent dans l'URL
if (isset($_GET['img']) && !empty($_GET['img'])) {
    $fileName = basename($_GET['img']);
    $filePath = $uploadsDir . '/' . $fileName;

    // Vérifiez que le fichier existe et est une image
    if (file_exists($filePath) && getimagesize($filePath)) {
        header('Content-Type: ' . mime_content_type($filePath));
        readfile($filePath);
        exit;
    }
}

// Si le fichier n'existe pas ou n'est pas une image, affichez un message d'erreur
http_response_code(404);
echo 'Fichier non trouvé ou invalide.';