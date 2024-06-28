<?php
// Import des services nécessaires
require_once '../../../models/Owner.php';
require_once '../../../services/OwnerService.php';
require_once '../../../services/SessionService.php';

// Récupération des genres de la plateforme
require_once '../../../services/GenderService.php';
$genders = GenderService::GetAllGenders();

// Fonction de redirection
function redirect($url)
{
    header('Location: ' . $url);
    exit();
}

// Vérifier l'authentification du owner
SessionService::system('owner', '/owner/profile');
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
    <link rel="stylesheet" href="../components/Toast/Toast.css">
    <script src="https://kit.fontawesome.com/a12680d986.js" crossorigin="anonymous"></script>

    <script type="module" src="/owner/ownerProfile/owner-profile.js"></script>

    <link rel="stylesheet" href="../../style/ui.css">
</head>

<body>

    <?php
    require_once ("../../components/Header/header.php");
    Header::render(isScrolling: True, isBackOffice: True, isAuthenticated: $isAuthenticated, redirectAuthPath: '/back/profile');
    ?>
    <main class="content">
        <nav>
            <ul>
                <li id="infos__btn" class="active">
                    <span>Informations Personnelles</span>
                    <div class="nav-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </li>
                <li id="security__btn">
                    <span>Sécurité</span>
                    <div class="nav-icon">
                        <i class="fa-solid fa-shield"></i>
                    </div>
                </li>

                <li id="api__btn">
                    <span>API</span>
                    <div class="nav-icon">
                        <i class="fa-solid fa-file-code"></i>
                    </div>
                </li>
            </ul>
        </nav>

        <div id="infos" class="content__personnal-data content__display">
            <h3 class="content__personnal-data__title">Informations Personnelles</h3>

            <div class="content__personnal-data__top">
                <p class="content__personnal-data__top__description">Modifier vos informations Personnelles</p>

                <img id="profile-image" class="content__personnal-data__image" src="<?= $owner->getImage()->getImageSrc() ?>" alt="photo_de_profile" onclick="document.getElementById('image-input').click()">
                
            </div>
            
            <form method="POST" action="/controllers/owner/ownerUpdateController.php" enctype="multipart/form-data">
                <input type="file" id="image-input" name="profileImage" accept="image/*" style="display: none;" onchange="previewImage(event)">
                <div class="content__personnal-data__elements">
                    <!-- Nom -->
                    <?php require_once ("../../components/Input/Input.php");

                    Input::render("uneClassEnPlus", "lastname", "text", "Nom", "lastname", "Nom", true, $owner->getLastname(), '1', '100'); ?>

                    <!-- Prenom -->
                    <?php
                    Input::render("uneClassEnPlus", "firstname", "text", "Prenom", "firstname", "Prenom", true, $owner->getFirstname(), '1', '100'); ?>

                    <!-- Pseudo -->
                    <?php
                    Input::render("uneClassEnPlus", "nickname", "text", "Pseudo", "nickname", "Pseudo", true, $owner->getNickname(), '1', '100'); ?>

                    <!-- Mail -->
                    <?php
                    Input::render("uneClassEnPlus", "mail", "email", "Mail", "mail", "Mail", true, $owner->getMail(), '1', '100'); ?>

                    <!-- Telephone -->
                    <?php
                    Input::render("uneClassEnPlus", "phoneNumber", "tel", "Telephone", "phoneNumber", "Telephone", true, $owner->getPhoneNumber(), '10', '12'); ?>

                    <!-- Adresse -->
                    <?php
                    Input::render("uneClassEnPlus", "address", "text", "Adresse", "address", "Adresse", true, $owner->getAddress()->getPostalAddress(), "1", "200"); ?>

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
                    <input type="hidden" name="creationDate"
                        value="<?php echo ($owner->getCreationDate()->format('Y-m-d')) ?>">
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
        <div id="security" class="content__security">
            <h3 class="content__security__title">Sécurité</h3>
            <p class="content__security__description">Modifier vos paramètres de sécurités</p>
            <form method="POST" action="/owner/ownerForgotPassword/reset-password-action.php">
                <div class="content__security__elements">
                    <?php
                    Input::render(
                        "content__security__elements__password",
                        "firstPasswordEntry",
                        "password",
                        "Modifier Mot de passe",
                        "firstPasswordEntry",
                        "Mot de passe",
                        true,
                        "",
                        "10",
                        "",
                        "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                    );
                    ?>
                    <?php
                    Input::render(
                        "content__security__elements__password--confirmation",
                        "secondPasswordEntry",
                        "password",
                        "Confirmer Mot de passe",
                        "secondPasswordEntry",
                        "Confirmer Mot de passe",
                        true,
                        "",
                        "10",
                        "",
                        "^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                    );
                    ?>
                    <input type="hidden" name="ownerID" value="<?php echo ($owner->getOwnerID()) ?>">
                    <div class="content__security__elements__required__fields">
                        <p id="length" class="content__security__elements__required__fields__length">La taille du mot de
                            passe doit être égale ou supérieure à 8</p>
                        <p id="contains" class="content__security__elements__required__fields__contains">Le mot de passe
                            doit contenir:</p>
                        <p id="uppercase" class="content__security__elements__required__fields__uppercase">1 Majuscule
                            minimum</p>
                        <p id="lowercase" class="content__security__elements__required__fields__lowercase">1 Minuscule
                            minimum</p>
                        <p id="digit" class="content__security__elements__required__fields__digit">1 chiffre minimum</p>
                    </div>
                    <div class="content__security__elements__modify_button">
                        <?php
                        require_once ("../../components/Button/Button.php");

                        Button::render("button--storybook", "modifier", "Valider les modifications", ButtonType::Owner, "", false, true); ?>
                    </div>
                </div>
        </div>
        <div id="api" class="content__api">
            <div class="content__api__contents">
                <div class="content__api__contents__titles">
                    <h3 class="content__api__contents__titles__title">API</h3>
                    <p class="content__api__contents__titles__description">Gérer vos clés d'API</p>
                </div>
                <?php Button::render("button--api", "api", "Créer une nouvelle clé API", ButtonType::Owner, "", false, true); ?>
            </div>

            <div class="content__api__keys">
                <script type="module" src="/owner/ownerProfile/getApiKeys.js"></script>
            </div>
        </div>
    </main>

    <?php
    require_once ("../../components/Footer/footer.php");
    Footer::render();
    ?>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('profile-image');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

    <script type="module" src="/owner/ownerProfile/owner-profile.js"></script>
</body>

</html>