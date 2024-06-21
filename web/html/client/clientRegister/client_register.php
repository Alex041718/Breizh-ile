<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Compte Client</title>
    <link rel="stylesheet" href="../../style/ui.css">
    <link rel="stylesheet" href="/client/clientRegister/client_register.css">
    <script src="/client/clientRegister/client_register.js"></script>
</head>
<body>

    <div class="connectionContainer connectionContainer--register">
        <div class="connectionContainer__box">
            <a href="/">
                <img src="../../assets/images/logo_breizh_noir.png">
            </a>
            <h3 class="connectionContainer__box__title">Création de votre compte client</h3>
            <?= isset($_GET["error"]) && $_GET["error"] != "" ? '<p class="error">' . $_GET["error"] . '</p>' : "" ?>
            <form data-success="<?= $_GET["success"] ?>" id="inscription" action="/client/clientRegister/sendAccountCreation.php" method="post">
                <?php require_once("../../components/Input/Input.php"); ?>
                <?php require_once("../../components/Button/Button.php"); ?>
                
                <div class="form__success" id="page0">
                    <p>Un mail contenant un code de vérification vous a été envoyé. Veuillez le saisir dans le champ ci-dessous.</p>
                    <?php Input::render("connection__input", "lastName", "text", null, "lastName", "Code", true); ?>
                    <?php Button::render("connection__button", "submitBtn", "Valider",ButtonType::Client,false,false,true); ?>
                </div>

                <div class="form__section" id="page1">
                    <?= (isset($_GET["redirect"]) ? "<input type='hidden' name='redirect' value='" . $_GET["redirect"] . "'>" : "<input type='hidden' name='redirect' value='" . "/back" . "'>") ?>

                    <div class="connection__input__genders">
                        <label class="input__label para--18px" for="gender">Genre <span class="require">*</span></label>
                        <div class="connection__input__genders-container">
                            <?php Input::render("connection__input__gender", "male", "radio", "Homme", "gender", "Entrez votre adresse email", false); ?>
                            <?php Input::render("connection__input__gender", "fename", "radio", "Femme", "gender", "Entrez votre adresse email", false); ?>
                            <?php Input::render("connection__input__gender", "other", "radio", "Autre", "gender", "Entrez votre adresse email", false); ?>
                        </div>
                    </div>

                    <div class="connectionContainer__box__line">
                        <?php Input::render("connection__input", "lastName", "text", "Nom", "lastName", "Nom", true); ?>
                        <?php Input::render("connection__input", "firstName", "text", "Prénom", "firstName", "Prénom", true); ?>
                    </div>

                    <?php Input::render("connection__input", "nickname", "text", "Nom d'utilisateur", "nickname", "Nom d'utilisateur", true); ?>

                </div>

                <div class="form__section" id="page2">
                    <?php Input::render("connection__input", "email", "email", "Adresse email", "mail", "Entrez votre adresse email", true); ?>
                    <?php Input::render("connection__input", "birthdate", "date", "Date de naissance", "birthdate", "Nom", true); ?>

                    
                </div>

                <div class="form__section" id="page3">
                    <?php Input::render("connection__input", "password", "password", "Mot de passe", "password", "Entrez votre mot de passe", true); ?>
                    <?php Input::render("connection__input confirm__input", "confirm", "password", null, "confirm", "Confirmer votre mot de passe", true); ?>
                    <?php Input::render("consent__input", "confirm", "checkbox", "Je consens à ce que mes données soient collectées et stockées pour le bon fonctionnement du site.", "consent", "", true); ?>
                </div>

                <input type="hidden" name="role" value="client">

                <div class="connectionContainer__box__line">
                    <?php Button::render("previous__button", "previousBtn", "Précédent",ButtonType::class,false,false,false); ?>
                    <?php Button::render("next__button", "nextBtn", "Suivant",ButtonType::class,false,false,false); ?>
                </div>

                <?php Button::render("connection__button", "submitBtn", "S'inscrire",ButtonType::Client,false,false,true); ?>

            </form>
            <?= isset($_GET["success"]) && $_GET["success"] === true ?
            '<div class="inscription">
                <div class="horizontal-line"></div>
                <p>OU</p>
                <div class="horizontal-line"></div>
            </div>
            <p class="para--18px">Déjà client ? <a href="/client/connection">Se connecter</a> </p>' : "" ?>

            
    </div>
</body>
</html>
