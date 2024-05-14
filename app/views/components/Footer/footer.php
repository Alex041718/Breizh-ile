<?php

class Footer {

    public static function render() {


        $render =  /*html*/ '

        <link rel="stylesheet" href="/views/components/Footer/footer.css">
        
        <footer>
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
                            <a href=""><p>Confidentialité</p></a>
                            <a href=""><p>Conditions générales d&#039;utilisation</p></a>
                        </div>
                    </div>
                    <div>
                        <h4>Votre compte</h4>
                        <div>
                            <a href=""><p>Devenir propriétaire</p></a>
                            <a href=""><p>Changer de langue</p></a>
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
