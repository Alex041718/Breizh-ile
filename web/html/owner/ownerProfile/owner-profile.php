<?php
// Import des services nécessaires
require_once '../../../models/Owner.php';
require_once '../../../services/OwnerService.php';
require_once '../../../services/SessionService.php';
require_once '../../../services/GenderService.php';
$genders = GenderService::GetAllGenders();

// Fonction de redirection
function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

// Vérifier l'authentification du owner
SessionService::system('owner', '/back/profile');
$isAuthenticated = SessionService::isOwnerAuthenticated();

if (!$isAuthenticated) {
    redirect('/login'); // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
}

// Récupérer le owner authentifié
$ownerID = $_SESSION['user_id'];
$owner = OwnerService::GetOwnerById($ownerID);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="/owner/ownerProfile/owner-profile.css">
</head>

<body>
    <?php
    require_once("../../components/Header/header.php");
    Header::render(isScrolling: True, isBackOffice: True, isAuthenticated: $isAuthenticated, redirectAuthPath: '/back/profile');
    ?>
    <main class="content">
        <nav>
            <ul>
                <li id="infos__btn" class="active"><span>Informations Personnelles</span></li>
                <li id="security__btn"><span>Sécurité</span></li>

            </ul>
        </nav>
        <div id="infos" class="content__personnal-data content__display">
            <h3 class="content__personnal-data__title">Informations Personnelles</h3>

            <div class="content__personnal-data__top">
                <p class="content__personnal-data__top__description">Modifier vos informations Personnelles</p>

                <img class="content__personnal-data__image" src="<?= $owner->getImage()->getImageSrc() ?>"
                    alt="photo_de_profile">
            </div>

            <form method="POST" action="/controllers/owner/ownerUpdateController.php">
                <div class="content__personnal-data__elements">
                    <!-- Nom -->
                    <?php require_once ("../../components/Input/Input.php");
                    Input::render("uneClassEnPlus", "lastname", "text", "Nom", "lastname", "Nom", true, $owner->getLastname(),'1','100'); ?>

                    <!-- Prenom -->
                    <?php
                    Input::render("uneClassEnPlus", "firstname", "text", "Prenom", "firstname", "Prenom", true, $owner->getFirstname(),'1','100'); ?>

                    <!-- Pseudo -->
                    <?php
                    Input::render("uneClassEnPlus", "nickname", "text", "Pseudo", "nickname", "Pseudo", true, $owner->getNickname(),'1','100'); ?>

                    <!-- Mail -->
                    <?php
                    Input::render("uneClassEnPlus", "mail", "email", "Mail", "mail", "Mail", true, $owner->getMail(),'1','100'); ?>

                    <!-- Telephone -->
                    <?php
                    Input::render("uneClassEnPlus", "phoneNumber", "tel", "Telephone", "phoneNumber", "Telephone", true, $owner->getPhoneNumber(),'10','12'); ?>

                    <!-- Adresse -->
                    <?php
                    Input::render("uneClassEnPlus", "address", "text", "Adresse", "address", "Adresse", true, $owner->getAddress()->getPostalAddress(),"1","200"); ?>

                    <!-- Genre -->
                    <div class="content__personnal-data__elements__genre">
                        <label for="genderID">Genre</label>
                        <select name="genderID" id="genderID" class="content__personnal-data__elements__select">
                            <?php foreach ($genders as $gender): ?>
                                <option <?= $owner->getGender()->getGenderID() == $gender->getGenderID() ? "selected" : "" ?>
                                    value="<?= $gender->getGenderID() ?>"><?= $gender->getLabel() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Date de naissance -->
                    <?php
                    Input::render("uneClassEnPlus", "birthDate", "date", "Date de naissance", "birthDate", "Date de naissance", false, $owner->getBirthDate()->format('Y-m-d')); ?>

                    <!-- Date de création du compte -->

                    <input type="hidden" name="creationDate" value="<?php echo ($owner->getCreationDate()->format('Y-m-d')) ?>">

                    <input type="hidden" name="ownerID" value="<?php echo ($owner->getOwnerID()) ?>">

                </div>
                <!-- Confirmer modifications button -->
                <div class="content__personnal-data__elements__modify_button">
                    <?php
                    require_once ("../../components/Button/Button.php");
                    Button::render("button--storybook", "modifier", "Valider les modifications", ButtonType::Owner, "", false, true); ?>
                </div>
            </form>
        </div>
        <div class="content__security">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>

            <div class="content__security__elements">
                <?php
                Input::render("content__security__elements__password", "password", "password", "Modifier Mot de passe", "password", "Mot de passe", true); ?>
            </div>
            <div class="content__security__moderator">
                <?php
                Button::render("button--storybook", "deactivate-account", "Désactiver mon compte", ButtonType::Delete, true); ?>

                <?php
                Button::render("button--storybook", "delete-account", "Supprimer mon compte", ButtonType::Delete, true); ?>
            </div>
        </div>
    </main>

    <?php
    require_once ("../../components/Footer/footer.php");
    Footer::render();
    ?>
    <script src="/owner/ownerProfile/owner-profile.js"></script>
</body>

</html>