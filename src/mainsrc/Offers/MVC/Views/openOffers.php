<?php
/**
 * Implementierung: angebote.html -> hier sind alle Offers aufgelistet, die noch buchbar sind, also wo der status noch auf frei ist bspw. als Suchergebnisse oder alle von einem bestimmten Typ
 */
?>
<!DOCTYPE html>
<html lang="de" style="height: 100%">
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
        <h2 class="nav--heading">TeachGym</h2>
        <h2 class="nav--heading nav--heading-small">TG</h2>
        <form method="post" class="nav--explore">
                <div class="nav--switch nav--switch-active border--left">
                    Schüler
                </div>
                <button name="changeView" value="changeView" type="submit" class="nav--switch border--right">
                    Lehrer
                </button>
        </form>
        <div class="icon--button nav--explore-toggle" onclick="openPopupToggle()"><i class="fa-solid fa-repeat"></i></div>
        <div class="icon--button nav--notification" onclick="openLogPopup()"><div class="icon--button-new <?php if(!empty($logDelivered)){ ?>icon--button-new-active<?php } ?>"></div><i class="fa-regular fa-bell"></i></div>
        <div class="icon--button icon--button-profil nav--profil"><i class="fa-regular fa-user"></i></div>
        <a href="/logout" class="nav--username" >Logout</a>
    </nav>
    <div class="nav--sub">
        <div onclick="openFilterPopup()" class="nav--sub-action"><i style="margin-right: 0.2em" class="fa-solid fa-filter"></i> Filtern</div>
        <div onclick="openPopupSubNavToggle()" style="margin-left: 1rem; text-decoration: none" class="nav--sub-action nav--sub-hide-more"><i style="margin-right: 0.2em" class="fa-regular fa-compass"></i> Navigation</div>
        <a href="/angeboteGebucht" style="margin-left: 1rem; text-decoration: none" class="nav--sub-action nav--sub-hide"><i style="margin-right: 0.2em" class="fa-regular fa-bookmark"></i> Gebuchte Angebote ansehen</a>
        <a href="/angeboteAngefragt" style="margin-left: 1rem; text-decoration: none" class="nav--sub-action nav--sub-hide"><i style="margin-right: 0.2em" class="fa-regular fa-hand"></i> Angefragte Angebote ansehen</a>
    </div>
</header>
<main class="offers--container">
    <?php if(!empty($offersData)){ ?>
        <?php foreach ($offersData as $item): ?>
            <?php if(!empty($errorFach)){ ?>
                <div style="grid-column: 1 / 4;" class="angebote--grid-filter-container">
                    <a class="angebote--grid-filter" href="/angeboteGebucht"><?php echo ucfirst($errorFach); ?> - Filter zurücksetzen</a>
                </div>
            <?php }?>
            <div class="angebote--item">
                <div class="<?php echo "$item->fach" . "-bg" ?> angebote--item-header">
                    <div class="angebote--item-icon">
                        <?php include __DIR__ . "/../../../Home/MVC/Views/Design/$item->fach.php"?>
                    </div>
                </div>
                <div class="angebote--item-content">
                    <h2 class="angebote--item-heading" style="margin-bottom: 0.5rem"><?php echo ucfirst($item->fach) ?></h2>
                    <p class="angebote--item-booked-name" style="font-weight: bold;"><?php echo ucfirst($item->lehrer) ?></p>
                    <p class="angebote--item-booked-name"><?php echo "$item->jahrgang" . ".Klasse"?></p>
                    <div class="angebote--item-status angebote--item-status-belegt" style="margin-top: 0.5rem;">Offen</div>
                    <a href="/angeboteOffenDetails?id=<?php echo "$item->id" ?>" style="margin-top: 1rem" class="angebote--item-button">Nachhilfe anfragen</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php } else { ?>
        <?php if(!empty($errorFach)){ ?>
            <a class="angebote--grid-filter" href="/angeboteOffen"><?php echo ucfirst($errorFach); ?> - Filter zurücksetzen</a>
        <?php } ?>
        <div class="angebote--grid" style="display: flex; align-items: center; justify-content: center; grid-column: 1 / 4">
            <h2 class="header--content-heading header--content-heading-center">Keine freien Angebote verfügbar.</h2>
        </div>
    <?php } ?>
</main>

<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<!--
<section id="angebotErstellenPopup" class="popup--hide popup--container-medium">
    <div onclick="closePopupErstellen()" class="popup--container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup--container-header">
        <h2 class="popup--container-heading">Neues Angebot Erstellen</h2>
    </div>
    <form method="post">
        <div class="popup--form-container">
            <p class="popup--form-label">Wähle das Fach deines Angebots</p>
            <div class="form--select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form--select-button">
                    <span class="form--select-value">Fach auswählen</span>
                    <span class="form--select-arrow"></span>
                </button>
                <ul class="form--select-list" role="listbox">
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="mathe" value="mathe">
                        <label for="mathe">Mathe</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="deutsch" value="deutsch">
                        <label for="deutsch">Deutsch</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="bio" value="bio">
                        <label for="bio">Bio</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="physik" value="physik">
                        <label for="physik">Physik</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="informatik" value="informatik">
                        <label for="informatik">Informatik</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="kunst" value="kunst">
                        <label for="kunst">Kunst</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="musik" value="musik">
                        <label for="musik">Musik</label>
                    </li>
                </ul>
            </div>
            <p class="popup--form-label popup--form-margin">Setze den Status deines Angebots</p>
            <div class="popup--form-radio-container">
                <div class="popup--form-radio-group">
                    <input type="radio" value="offen" name="angebot--status" id="angebot--status-offen" checked>
                    <label class="popup--form-label" for="angebot--status-offen">Offen</label>
                </div>
                <div class="popup--form-radio-group">
                    <input type="radio" value="gebucht" name="angebot--status" id="angebot--status-geschlossen">
                    <label class="popup--form-label" for="angebot--status-geschlossen">Geschlossen</label>
                </div>
            </div>
            <p class="popup--form-label popup--form-margin">Lege die Jahrgangsstufe fest, an wen sich dein Angebot richtet:</p>
            <div class="form--select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form--select-button">
                    <span class="form--select-value">Jahrgänge ankreuzen</span>
                    <span class="form--select-arrow"></span>
                </button>
                <ul class="form--select-list" role="listbox">
                    <li class="form--select-option" role="option">
                        <input type="checkbox" name="alter[]" id="fünf" value="5">
                        <label for="fünf">5.Klasse</label>
                    </li>
                    <li class="form--select-option" role="option">
                        <input type="checkbox" name="alter[]" id="sechs" value="6">
                        <label for="sechs">6.Klasse</label>
                    </li>
                    <li class="form--select-option" role="option">
                        <input type="checkbox" name="alter[]" id="sieben" value="7">
                        <label for="sieben">7.Klasse</label>
                    </li>
                    <li class="form--select-option" role="option">
                        <input type="checkbox" name="alter[]" id="acht" value="8">
                        <label for="acht">8.Klasse</label>
                    </li>
                    <li class="form--select-option" role="option">
                        <input type="checkbox" name="alter[]" id="neun" value="9">
                        <label for="neun">9.Klasse</label>
                    </li>
                </ul>
            </div>
            <div class="profil--card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit">
                    <i class="btn-submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Erstellen</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="btn-reset-icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>
-->
<section class="popup--hide popup--container-medium popup--container-small popup--container-right filterPopup">
    <div onclick="closeFilterPopup()" class="popup--container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup--container-header">
        <h2 class="popup--container-heading">Angebote filtern</h2>
    </div>
    <form method="post">
        <div class="popup--form-container" >
            <p class="popup--form-label">Wähle das Fach deines Angebots</p>
            <div class="form--select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form--select-button form--select-button-radio">
                    <span class="form--select-value form--select-value-radio">Fach auswählen</span>
                    <span class="form--select-arrow"></span>
                </button>
                <ul class="form--select-list" role="listbox">
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="mathe" value="mathe">
                        <label for="mathe">Mathe</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="deutsch" value="deutsch">
                        <label for="deutsch">Deutsch</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="bio" value="bio">
                        <label for="bio">Bio</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="physik" value="physik">
                        <label for="physik">Physik</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="informatik" value="informatik">
                        <label for="informatik">Informatik</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="kunst" value="kunst">
                        <label for="kunst">Kunst</label>
                    </li>
                    <li class="form--select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="musik" value="musik">
                        <label for="musik">Musik</label>
                    </li>
                </ul>
            </div>
            <div class="profil--card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit">
                    <i class="btn-submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Filtern</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="btn-reset-icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>

<section id="toggleView" class="popup--hide popup--container-medium popup--container-small popup--container-right">
    <div onclick="closePopupToggle()" class="popup--container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup--container-header">
        <h2 class="popup--container-heading">Ansicht wechseln</h2>
    </div>
    <form method="post" style="display: flex; flex-direction: row; align-items: center; justify-content: center">
        <div class="popup--sub-nav-container" >
            <div class="nav--switch nav--switch-active border--left">
                Schüler
            </div>
            <button style="color: #F3F4F6" name="changeView" value="changeView" type="submit" class="nav--switch border--right">
                Lehrer
            </button>
        </div>
    </form>
</section>

<section id="toggleSubNavView" class="popup--hide popup--container-medium popup--container-small popup--container-right">
    <div onclick="closePopupSubNavToggle()" class="popup--container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup--container-header">
        <h2 class="popup--container-heading">Navigieren</h2>
    </div>
    <div class="nav--sub-list">
        <a href="/angeboteGebucht" style="margin-left: 1rem; text-decoration: none" class="nav--sub-action nav--sub-action-dark"><i style="margin-right: 0.2em" class="fa-regular fa-bookmark"></i> Gebuchte Angebote ansehen</a>
        <a href="/angeboteAngefragt" style="margin-left: 1rem; text-decoration: none" class="nav--sub-action nav--sub-action-dark"><i style="margin-right: 0.2em" class="fa-regular fa-hand"></i> Angefragte Angebote ansehen</a>
    </div>
</section>

<div style="margin-top: 15rem; width: 100%">
    <?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
</div>
<div id="angebotLehrerOverlay" class="popup--hide popup--overlay"></div>
<?php require_once __DIR__ . "/../../../App/Base/logInfo.php"; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../../../../scripts/offer.js"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<?php require_once __DIR__ . "/../../../App/Base/logScripts.php"; ?>
</body>
</html>

