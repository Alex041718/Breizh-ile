<?php
// imports
require_once '../../services/SessionService.php';

// Gestion de la session
SessionService::system('admin','../../views/admin/adminConnection.php');
?>


<html>
    <head>
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="../style/ui.css">
    </head>
    <body>
        <h1>Admin Dashboard</h1>
        <ul>
            <li><a href="housingDashboard.php">Gestion des logements</a></li>
            <li><a href="typeDashboard.php">Gestion des types</a></li>
            <li><a href="categoryDashboard.php">Gestion des catégories</a></li>
            <li><a href="addressDashboard.php">Gestion des adresses</a></li>
            <li><a href="ownerDashboard.php">Gestion des propriétaires</a></li>
            <li><a href="imageDashboard.php">Gestion des images</a></li>
            <li><a href="arrangementDashboard.php">Gestion des aménagements</a></li>
        </ul>
    </body>
</html>
