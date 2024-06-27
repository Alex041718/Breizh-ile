<?php

require_once "../../../services/ApiKeyService.php";
require_once "../../components/Popup/popup.php";

session_start();

function showApiKeys($apiKeys) {
    $codePopUp = /*html*/ '
        <section class="description-action">
            <h3>Changer l\'état de la clé API</h3>
            <p>Êtes-vous sûr de vouloir changer l\'état de cette clé API ?</p>
        </section>
        <section class="actions">
            <button type="button" class="button undo__button button--owner--secondary button--bleu " id="undoButton" onclick="document.querySelector(\'.popUpVisibility\').classList.remove(\'popup--open\');">Annuler</button>
            <button type="button" class="button accept__button button--delete button--rouge " id="acceptButton" onclick="">Changer l\'état</button>
        </section>
    ';

    if (empty($apiKeys)) { ?>
        <p class="no-api-keys">Vous n'avez aucune clé API.</p>
    <?php
    } else {
        foreach ($apiKeys as $index=>$apiKey) { ?>
            <div class="content__api__keys__key">
                <p class="copy content__api__keys__key__description">
                    <?= $apiKey->getApiKey() ?>
                    <i class="fa-solid fa-copy"></i>
                </p>
                <p class="description-status content__api__keys__key__description">
                    <?= $apiKey->isActive() ? "Active" : "Inactive" ?>
                    <span class="status status--<?= $apiKey->isActive() ? "online" : "offline" ?>"></span>
                </p>
                <button data-apikey="<?= $apiKey->getApiKey() ?>" data-index="<?= $index ?>" id="popUpApi-btn" class="eye"><i class="fa-solid fa-eye"></i></button>
            </div>
        <?php
        }
    }

    PopUp::render("popUpApi", "popUpApi-btn", $codePopUp);
}

$apiKeys = ApiKeyService::GetApiKeyByUserID($_SESSION["user_id"]);
showApiKeys($apiKeys);
?>