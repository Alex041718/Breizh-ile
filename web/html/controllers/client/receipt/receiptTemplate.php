<html>
    <head>
        <title>Facture</title>
        <link rel="stylesheet" href="receiptTemplate.css">
        <style>
            <?php include 'receiptTemplate.css'; ?>
        </style>
    </head>
    <body>
        <header>
            <p>Numéro de la réservation : <?php echo htmlspecialchars($reservationID); ?></p>
        </header>
        <main>
            <div class="receipt">
                <div class="receipt_summary">

                    <span>
                        <p>Facture N°<?php echo htmlspecialchars($receipt->getReceiptID()); ?></p>
                        <p>Nombre de personnes : <?php echo htmlspecialchars($reservation->getNbPerson()); ?></p>
                        <p>Date du paiement : <?php echo htmlspecialchars($receipt->getPaymentDate()->format('Y-m-d')); ?></p>
                        <p>Moyen de paiement : <?php echo htmlspecialchars($receipt->getPayMethod()->getLabel()); ?></p>

                        <p>Date d'arrivée : <?php echo htmlspecialchars($reservation->getBeginDate()->format('Y-m-d')); ?></p>
                        <p>Date départ : <?php echo htmlspecialchars($reservation->getEndDate()->format('Y-m-d')); ?></p>
                    </span>

                    <span>
                        <p>Information du logement :</p>
                        <ul>
                            <li>Nom du logement : <?php echo htmlspecialchars($reservation->getHousingId()->getTitle()); ?></li>
                            <li>Rue : <?php echo htmlspecialchars($reservation->getHousingId()->getAddress()->getPostalAddress()); ?></li>
                            <li>Ville : <?php echo htmlspecialchars($reservation->getHousingId()->getAddress()->getCity()); ?></li>
                            <li>Code postal : <?php echo htmlspecialchars($reservation->getHousingId()->getAddress()->getPostalCode()); ?></li>
                            <li>Pays : <?php echo htmlspecialchars($reservation->getHousingId()->getAddress()->getCountry()); ?></li>

                        </ul>

                    </span>

                    <span>
                        <p>Information du propriétaire :</p>
                        <ul>
                            <li>Nom du propriétaire : <?php echo htmlspecialchars($reservation->getHousingId()->getOwner()->getFirstname()); ?> <?php echo htmlspecialchars($reservation->getHousingId()->getOwner()->getLastname()); ?></li>
                            <li>Numéro de téléphone : <?php echo htmlspecialchars($reservation->getHousingId()->getOwner()->getPhoneNumber()); ?></li>
                        </ul>
                    </span>

                </div>
                <div class="receipt_table">

    <table>
        <thead>
        <tr>
            <th>Désignation</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total HT</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="designation">Nuitée</td>
            <td class="right-nb"><?php echo htmlspecialchars($intervalDay = $reservation->getBeginDate()->diff($reservation->getEndDate())->days); ?></td>
            <td class="right-nb"><?php echo htmlspecialchars($receipt->getReservation()->getPriceIncl()); ?> €</td>
            <td class="right-nb"><?php echo htmlspecialchars($intervalDay*$receipt->getReservation()->getPriceIncl()); ?> €</td>
        </tr>
        <tr>
            <td class="designation">Frais de service (1%)</td>
            <td class="right-nb">1</td>
            <td class="right-nb"><?php echo htmlspecialchars(number_format($receipt->getReservation()->getServiceCharge(), 2)); ?> €</td>
            <td class="right-nb"><?php echo htmlspecialchars(number_format($receipt->getReservation()->getServiceCharge(), 2)); ?> €</td>
        </tr>
        <tr>
            <td class="designation">Taxe de séjour (nombre de personnes x nombre de nuitées)</td>
            <td class="right-nb"><?php echo htmlspecialchars($receipt->getReservation()->getNbPerson() * $intervalDay); ?> €</td>
            <td class="right-nb"></td>
            <td class="right-nb"><?php echo htmlspecialchars($receipt->getTouristTax()); ?> €</td>
        </tr>
        <tr>
            <td class="invisible-cell" colspan="1"></td>
            <td colspan="2">Sous Total HT</td>
            <td class="right-nb"><?php echo htmlspecialchars($receipt->getTouristTax() + $receipt->getReservation()->getServiceCharge() + $intervalDay*$receipt->getReservation()->getPriceIncl()); ?> €</td>
        </tr>
        <tr>
            <td class="invisible-cell" colspan="1"></td>
            <td colspan="2">TVA %</td>
            <td class="right-nb"><?php echo htmlspecialchars(number_format($receipt->getTVA() * 100), 2); ?> %</td>
        </tr>
        <tr>
            <td class="invisible-cell" colspan="1"></td>
            <td colspan="2">Total TVA</td>
            <td class="right-nb"><?php echo htmlspecialchars(number_format($receipt->getTotalTVA(), 2)); ?> €</td>
        </tr>
        <tr>
            <td class="invisible-cell" colspan="1"></td>
            <td colspan="2">Total TTC</td>
            <td class="right-nb"><?php echo htmlspecialchars(number_format(($receipt->getTouristTax() + $receipt->getReservation()->getServiceCharge() + $intervalDay*$receipt->getReservation()->getPriceIncl()) * 1.2, 2)); ?> €</td>
        </tr>

        </tbody>
    </table>

</div>
            </div>
        </main>
    </body>
</html>
