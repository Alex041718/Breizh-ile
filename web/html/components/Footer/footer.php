<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
    
<?php

class Footer {

    public static function render($isBackOffice = false) {


        $render =  /*html*/ '
            <link rel="stylesheet" href="/style/ui.css">
            <link rel="stylesheet" href="/components/Footer/footer.css">
            
            <footer class="' . ($isBackOffice ? 'footer--backoffice' : '') . '">
                <section>
                    <div class="informations">
                        <div>
                            <h4>Nous connaître</h4>
                            <div>
                                <a href=""><p>Qui sommes nous</p></a>
                                <a href=""><p>Notre RSE</p></a>
                            </div>
                        </div>
                        <div>
                            <h4>Légal</h4>
                            <div>
                                <a href="/global/mentionsLegales/mentionsLegales.php"><p>Mentions Légales</p></a>
                                <a href="/global/cgv/cgv.php"><p>Conditions générales de vente</p></a>
                                <a href="/global/cgu/cgu.php"><p>Conditions générales d&#039;utilisation</p></a>
                            </div>
                        </div>
                        <div>
                            <h4>Votre compte</h4>
                            <div>
                                <a href="/back/register"><p>Devenir propriétaire</p></a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4>Copyright © 2024 - Designed by CrêpeTech</h4>
                    </div>
                </section>
            </footer>
        ';

        echo $render;
    }
}

?>
    
</html>