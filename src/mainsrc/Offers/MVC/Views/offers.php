<?php
/**
 * Implementierung: angebote.html -> hier sind alle Offers aufgelistet, bspw. als Suchergebnisse oder alle von einem bestimmten Typ
 */
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Angebote </title>
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Angebote, Übersicht, Uebersicht, gesucht, Suchen, Ergebnisse, neu, Neue Angebote,">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
</head>
<body style="background-color: #F3F4F6">
<header>
    <nav class="nav" style="background-color: #ffffff">
        <h2 class="nav__heading">TeachGym</h2>
        <div class="nav__explore">Entdecken... <i style="margin-left: 0.75rem" class="fa-solid fa-caret-left"></i></div>
        <div class="icon__button" style="position: absolute; right: 15rem"><i class="fa-regular fa-bell"></i></div>
        <div class="icon__button" style="position: absolute; right: 12rem"><i class="fa-regular fa-user"></i></div>
        <p class="nav__username" style="position: absolute; right: 5rem">Maurice Rösler</p>
    </nav>
    <div class="nav__sub">
        <div class="nav__sub-action"><i style="margin-right: 0.2em" class="fa-solid fa-filter"></i> Filtern</div>
        <div onclick="openPopupErstellen()" style="margin-left: 1rem" class="nav__sub-action"><i style="margin-right: 0.2em" class="fa-solid fa-plus"></i> Neues Angebot erstellen</div>
    </div>
</header>
<main class="offers__container">
    <?php if(!empty($lehrerAngebote)){ ?>
    <?php foreach ($lehrerAngebote as $item): ?>
        <div class="angebote__item">
            <div class="<?php echo ">
                <div class="angebote__item-icon">
                    <?php include __DIR__ . "/../../../Home/MVC/Views/Design/$item->fach.php"?>
                </div>
            </div>
            <div class="angebote__item-content">
                <h2 class="angebote__item-heading"><?php echo ucfirst($item->fach) ?> Kurs</h2>
                <div class="angebote__item-status angebote--item-status-belegt"><?php echo ucfirst($item->status) ?></div>
                <p class="angebote__item-requests-list">Anfragen:</p>
                <div class="angebote__item-request">
                    <div class="angebote__item-request-image"></div>
                    <p class="angebote__item-request-name">Max Mustermann</p>
                    <button class="angebote__item-request-add">ADD</button>
                </div>
                <div class="angebote__item-request">
                    <div class="angebote__item-request-image"></div>
                    <p class="angebote__item-request-name">Lisa Meier</p>
                    <button class="angebote__item-request-add">ADD</button>
                </div>
                <div class="angebote__item-request">
                    <div class="angebote__item-request-image"></div>
                    <p class="angebote__item-request-name">Tobias Neuhauer</p>
                    <button class="angebote__item-request-add">ADD</button>
                </div>
                <a href="/angeboteLehrerDetails?id=<?php echo "$item->id" ?>" class="angebote__item-button">Übersicht</a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php } else { ?>
    <div class="angebote__grid" style="display: flex; align-items: center; justify-content: center; grid-column: 1 / 4">
        <h2 class="header__content-heading">Noch keine Angebote erstellt</h2>
    </div>
    <?php } ?>
</main>

<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<section id="angebotErstellenPopup" class="popup--hide popup__ontainer--medium">
    <div onclick="closePopupErstellen()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Neues Angebot Erstellen</h2>
    </div>
    <form method="post">
        <div class="popup__form-container">
            <p class="popup__form-label">Wähle das Fach deines Angebots</p>
            <div class="form__select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form__select-button">
                    <span class="form--select-value">Fach auswählen</span>
                    <span class="form__select-arrow"></span>
                </button>
                <ul class="form__select-list" role="listbox">
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="mathe" value="mathe">
                        <label for="mathe">Mathe</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="deutsch" value="deutsch">
                        <label for="deutsch">Deutsch</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="bio" value="bio">
                        <label for="bio">Bio</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="physik" value="physik">
                        <label for="physik">Physik</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="informatik" value="informatik">
                        <label for="informatik">Informatik</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="kunst" value="kunst">
                        <label for="kunst">Kunst</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="musik" value="musik">
                        <label for="musik">Musik</label>
                    </li>
                </ul>
            </div>
            <p class="popup__form-label popup__form-margin">Setze den Status deines Angebots</p>
            <div class="popup__form-radio-container">
                <div class="popup__form-radio-group">
                    <input type="radio" value="offen" name="angebot--status" id="angebot--status-offen" checked>
                    <label class="popup__form-label" for="angebot--status-offen">Offen</label>
                </div>
                <div class="popup__form-radio-group">
                    <input type="radio" value="gebucht" name="angebot--status" id="angebot--status-geschlossen">
                    <label class="popup__form-label" for="angebot--status-geschlossen">Geschlossen</label>
                </div>
            </div>
            <p class="popup__form-label popup__form-margin">Lege die Jahrgangsstufe fest, an wen sich dein Angebot richtet:</p>
            <div class="form__select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form__select-button">
                    <span class="form--select-value">Jahrgänge ankreuzen</span>
                    <span class="form__select-arrow"></span>
                </button>
                <ul class="form__select-list" role="listbox">
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="fünf" value="5">
                        <label for="fünf">5.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="sechs" value="6">
                        <label for="sechs">6.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="sieben" value="7">
                        <label for="sieben">7.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="acht" value="8">
                        <label for="acht">8.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="neun" value="9">
                        <label for="neun">9.Klasse</label>
                    </li>
                </ul>
            </div>
            <div class="profil__card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Erstellen</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="button--reset__icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>
<div id="angebotLehrerOverlay" class="popup--hide popup__overlay"></div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../../../../scripts/offer.js"></script>
</body>
</html>
