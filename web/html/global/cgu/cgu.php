<?php 
    // ------------------- Systeme de session -------------------
    // Il faut tout ceci pour réccupérer la session de l'utilisateur sur une page où l'on peut ne pas être connecté
    require_once '../../../models/Client.php';
    require_once '../../../services/ClientService.php';
    require_once '../../../services/SessionService.php'; // pour le menu du header

    // Vérification de l'authentification de l'utilisateur
    $isAuthenticated = SessionService::isClientAuthenticated();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditions Générales d'Utilisation'</title>

    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="cgu.css">
</head>

<body>


    <p id="auth" style="display:none"><?=$isAuthenticated?></p>
    <?php
        require_once("../../components/Header/header.php");
        Header::render(true,false, $isAuthenticated);
    ?>
    <main class="global-ui">
        <?php
        require_once("../../components/BackComponent/BackComponent.php");
        BackComponent::render("backButton", "", "Retour", "");
        ?>
    <div class="cgu">
        <h2>Conditions Générales d'Utilisation (CGU)</h2>


        <div class="acces-site">
            <h3>ARTICLE 1 : ACCÈS AU SITE</h3>
            <p class="para--18px">Le site Breizh’Ile offre gratuitement divers services, tels que la location et la réservation de logements, ainsi que le service après-vente (SAV). Ces services sont accessibles gratuitement à tout utilisateur disposant d'une connexion Internet. Toutefois, l'accès aux services réservés nécessite une inscription préalable. L’utilisateur s'engage à fournir des informations précises lors de son inscription et à conserver la confidentialité de ses identifiants. La désinscription peut être demandée à tout moment.</p>
        </div>


        <div class="collecte-donnees">
            <h3>ARTICLE 2 : COLLECTE DES DONNÉES</h3>
            <p class="para--18px">Le site assure à l'Utilisateur une collecte et un traitement d'informations personnelles dans le respect de la vie privée relative à l'informatique, aux fichiers et aux libertés.<br>En vertu de la loi Informatique et Libertés, l'Utilisateur dispose d'un droit d'accès, de rectification, de suppression et d'opposition de ses données personnelles.<br>Les données personnelles de l'Utilisateur sont collectées et traitées conformément à la loi. L'Utilisateur peut exercer ses droits sur ses données personnelles par différents moyens.</p>
        </div>


        <div class="propriete-intellectuelle">
            <h3>ARTICLE 3 : PROPRIÉTÉ INTELLECTUELLE</h3>
            <p class="para--18px">Les marques, logos, signes ainsi que tous les contenus du site (textes, images…) font l'objet d'une protection par le Code de la propriété intellectuelle et plus particulièrement par le droit d'auteur.<br>La marque Breizh Ile est une marque déposée par CrêpeTech. Toute représentation / reproduction / exploitation partielle ou totale de cette marque, de quelque nature que ce soit, est totalement prohibée.<br>L'Utilisateur doit solliciter l'autorisation préalable du site pour toute reproduction, publication, copie des différents contenus. Il s'engage à une utilisation des contenus du site dans un cadre strictement privé, toute utilisation à des fins commerciales et publicitaires est strictement interdite.<br>Il est rappelé conformément à l’article L122-5 du Code de propriété intellectuelle que l’Utilisateur qui reproduit, copie ou publie le contenu protégé doit citer l’auteur et sa source.</p>
        </div>


        <div class="responsabilite">
            <h3>ARTICLE 4 : RESPONSABILITÉ</h3>
            <p class="para--18px">Le site ne garantit pas l'absence d'erreurs ou d'omissions. Il décline toute responsabilité en cas de dommage lié à l'utilisation du site. L'Utilisateur est responsable de la confidentialité de ses identifiants. Le site ne peut être tenu responsable des virus ou de la force majeure.</p>
        </div>


        <div class="liens-hypertextes">
            <h3>ARTICLE 5 : LIENS HYPERTEXTES</h3>
            <p class="para--18px">Des liens hypertextes peuvent être présents sur le site. L’Utilisateur est informé qu’en cliquant sur ces liens, il sortira du site www.breizh-ile.bzh. Ce dernier n’a pas de contrôle sur les pages web sur lesquelles aboutissent ces liens et ne saurait, en aucun cas, être responsable de leur contenu.</p>
        </div>


        <div class="cookies">
            <h3>ARTICLE 6 : COOKIES</h3>
            <p class="para--18px">Le site utilise des cookies pour améliorer l'expérience de l'Utilisateur. En naviguant sur le site, l'Utilisateur accepte l'utilisation de ces cookies. Il peut cependant les désactiver via les paramètres de son navigateur, bien que cela puisse affecter certaines fonctionnalités du site.</p>
        </div>


        <div class="publication-utilisateur">
            <h3>ARTICLE 7 : PUBLICATION PAR L’UTILISATEUR</h3>
            <p class="para--18px">Les Utilisateurs peuvent publier des annonces de logements en respectant les règles de conduite et de droit. Le site se réserve le droit de modérer ces publications. Les Utilisateurs restent propriétaires de leurs contenus mais accordent des droits à la société éditrice.</p>
        </div>


        <div class="droit-applicable">
            <h3>ARTICLE 8 : DROIT APPLICABLE ET JURIDICTION COMPÉTENTE</h3>
            <p class="para--18px">La législation française s'applique au présent contrat. En cas d'absence de résolution amiable d'un litige né entre les parties, les tribunaux français seront seuls compétents pour en connaître.<br>Pour toute question relative à l’application des présentes CGU, vous pouvez joindre l’éditeur aux coordonnées inscrites à l’ARTICLE 1.</p>
        </div>
    </div>

</main>
    <?php
        require_once("../../components/Footer/footer.php");
        Footer::render();
    ?>
</body>