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
    <title>Conditions Générales de Vente</title>

    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="cgv.css">
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
        BackComponent::render("backButton", "", "retour", "");
        ?>
        <div class="cgv">
               <h2>Conditions Générales de Vente (CGV)</h2>


               <div class="preambule">
                   <h3>Préambule</h3>
                   <p class="para--18px">Les présentes Conditions Générales de Vente régissent les relations contractuelles entre Breizh'Ile, filiale du groupe CrêpeTech, et ses clients. En réservant un logement sur notre site, vous acceptez sans réserve ces conditions.</p>
               </div>


               <div class="caracteristiques">
                   <h3>Article 1 - Caractéristiques essentielles du service offert :</h3>
                   <p class="para--18px">Notre entreprise, Breizh’Ile, propose des services de location de logements en Bretagne. Les caractéristiques essentielles de nos locations, telles que la localisation, la capacité d'accueil, les équipements inclus et les conditions de séjour, sont détaillées sur notre plateforme en ligne.</p>
               </div>


               <div class="coordonnees">
                   <h3>Article 2 - Coordonnées de Breizh’Ile :</h3>
                   <p class="para--18px">Adresse : 22 rue de la Crêpe, 22300 - Lannion FRANCE<br>Téléphone : +33 2 23 43 88 09<br>E-mail : contact@breizh-ile.com<br>Statut: Association loi 1901</p>
               </div>


               <div class="etendue-geographique">
                   <h3>Article 3 - Étendue Géographique :</h3>
                   <p class="para--18px">La disponibilité des logements peut varier selon les saisons et les localités. Les détails sur l'emplacement et les attractions locales sont disponibles sur le site de Breizh'Ile. Les réservations impliquent l'acceptation de la disponibilité géographique des logements.</p>
               </div>


               <div class="reservation">
                   <h3>Article 4 - Réservation et Location :</h3>
                   <p class="para--18px">Le Client peut effectuer une réservation sur le site web de Breizh'Ile selon les modalités définies sur celui-ci.<br>Toute réservation ou location vaut acceptation des présentes CGV.</p>
               </div>


               <div class="tarifs">
                   <h3>Article 5 - Tarifs :</h3>
                   <p class="para--18px">Les tarifs des logements proposés par Breizh'Ile sont indiqués en euros toutes taxes comprises (TTC).<br>Les tarifs sont modifiables par le propriétaire.<br>Les tarifs peuvent varier en fonction de la saison et de la durée de la location. Les tarifs applicables sont ceux en vigueur au moment de la réservation.<br>Les frais supplémentaires éventuels, tels que les frais de ménage ou de dépôt de garantie, sont clairement indiqués lors de la réservation.</p>
               </div>


               <div class="paiement">
                   <h3>Article 6 - Paiement :</h3>
                   <p class="para--18px">Le paiement de la réservation ou de la location s'effectue en ligne au moment de la réservation par carte bancaire ou tout autre moyen de paiement accepté par Breizh'Ile.<br>En cas de paiement par carte bancaire, le Client garantit qu'il est pleinement habilité à utiliser ladite carte et que celle-ci donne accès à des fonds suffisants pour couvrir tous les coûts résultant de la réservation ou de la location.</p>
               </div>


               <div class="annulation">
                   <h3>Article 7 - Annulation :</h3>
                   <p class="para--18px">En cas d'annulation par le Client, les conditions d'annulation et les éventuels remboursements sont précisés dans les conditions générales de réservation disponibles sur le site web de Breizh'Ile.<br>Breizh'Ile se réserve le droit d'annuler une réservation ou une location en cas de force majeure ou pour des raisons de sécurité.</p>
               </div>


               <div class="garantie">
                   <h3>Article 8 - Garantie :</h3>
                   <p class="para--18px">Les produits ou services vendus sur le Site bénéficient de la garantie légale de conformité et de la garantie contre les vices cachés.</p>
               </div>


               <div class="responsabilite">
                   <h3>Article 9 - Responsabilité :</h3>
                   <p class="para--18px">Breizh'Ile s'engage à fournir des logements conformes aux descriptions et aux photos présentées sur son site web.<br>La responsabilité de Breizh'Ile ne saurait être engagée en cas de dommages causés par un cas de force majeure ou par le fait d'un tiers.<br>Le Client est responsable du respect des règles de bon voisinage et des consignes de sécurité pendant sa location.</p>
               </div>


               <div class="litiges">
                   <h3>Article 10 - Litiges :</h3>
                   <p class="para--18px">En cas de litige, une tentative de résolution à l'amiable sera recherchée. À défaut de résolution amiable, les tribunaux compétents seront ceux du ressort du siège social de Breizh'Ile.</p>
               </div>


               <div class="donnees-personnelles">
                   <h3>Article 11 - Données Personnelles :</h3>
                   <p class="para--18px">Breizh'Ile collecte et traite les données personnelles de ses clients conformément à sa Politique de Confidentialité. Ces informations sont utilisées dans le seul but de faciliter les transactions et d'améliorer l'expérience utilisateur. Breizh'Ile s'engage à protéger la confidentialité et la sécurité des données personnelles de ses clients.</p>
               </div>


               <div class="garantie-commerciale">
                   <h3>Article 12 - Existence et modalité de mise en œuvre de la garantie commerciale et d'un service après-vente :</h3>
                   <p class="para--18px">Nous offrons une garantie commerciale sur nos locations conformément aux dispositions légales en vigueur. Les modalités de mise en œuvre de cette garantie seront communiquées au client lors de la conclusion du contrat.</p>
               </div>


               <div class="droit-retractation">
                   <h3>Article 13 - Droit de rétractation :</h3>
                   <p class="para--18px">Conformément à la législation en vigueur, le client dispose d'un délai de rétractation de 14 jours à compter de la conclusion du contrat pour exercer son droit de rétractation. Le formulaire type de rétractation peut être demandé à [adresse e-mail de l'entreprise] ou consulté sur notre site web.</p>
               </div>
           </div>
    </main>
       <?php
            require_once("../../components/Footer/footer.php");
            Footer::render();
        ?>
</body>
</html>