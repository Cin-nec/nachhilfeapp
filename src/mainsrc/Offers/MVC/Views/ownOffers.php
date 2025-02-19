<?php
/**
 * Implementierung: angebote.html -> hier sind alle Offers aufgelistet, bspw. als Suchergebnisse oder alle von einem bestimmten Typ
 */
$permission = $_SESSION["userPermission"];
?>
<!DOCTYPE html>
<html style="height: 100%" lang="de">
<head>
    <meta charset="UTF-8">
    <title>Angebote </title>
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Angebote, Übersicht, Uebersicht, gesucht, Suchen, Ergebnisse, neu, Neue Angebote,">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
    <?php if($permission == "teacher"){ ?>
        <link href="../../../../styles/darktheme.css" type="text/css" rel="stylesheet">
    <?php } ?>
</head>
<body style="<?php if($permission == "teacher"){ ?> background-color: #374151; <?php } else { ?>background-color: #F3F4F6<?php } ?>">
<header>
    <nav class="nav">
        <h2 class="nav--heading">TeachGym</h2>
        <h2 class="nav--heading nav__heading--small">TG</h2>
        <form method="post" class="nav__explore">
            <button name="changeView" value="changeView" type="submit" class="nav--switch border--left">
                Schüler
            </button>
            <div class="nav--switch nav--switch-active border--right">
                Lehrer
            </div>
        </form>
        <div class="icon--button nav__explore-toggle" onclick="openPopupToggle()"><i class="fa-solid fa-repeat"></i></div>
        <div class="icon--button nav__notification" onclick="openLogPopup()" ><div class="icon__button--new <?php if(!empty($logDelivered)){ ?>icon--button-new-active<?php } ?>"></div><i class="fa-regular fa-bell"></i></div>
        <div class="icon--button icon--button-profil nav__profil"><i class="fa-regular fa-user"></i></div>
        <a href="/logout" class="nav--username" >Logout</a>
    </nav>
    <div class="nav--sub">
        <div onclick="openFilterPopup()" class="nav__sub-action"><i style="margin-right: 0.2em" class="fa-solid fa-filter"></i> Filtern</div>
        <p onclick="openPopupErstellen()" style="margin-left: 1rem" class="nav__sub-action"><i style="margin-right: 0.2em" class="fa-solid fa-plus"></i> Neues Angebot</div>
    </div>
</header>
<main class="offers__container">
    <?php if(!empty($lehrerAngebote)){ ?>
        <?php foreach ($lehrerAngebote as $item): ?>
            <?php if(!empty($errorFach)){ ?>
                <div style="grid-column: 1 / 4;" class="angebote__grid-filter-container">
                    <a class="angebote__grid-filter" href="/angeboteLehrer"><?php echo ucfirst($errorFach); ?> - Filter zurücksetzen</a>
                </div>
            <?php }?>
            <div class="angebote--item">
                <div class="<?php echo ">
                    <div class="angebote__item-icon">
                        <?php include __DIR__ . "/../../../Home/MVC/Views/Design/$item->fach.php"?>
                    </div>
                </div>
                <div class="angebote__item-content">
                    <h2 class="angebote--item-heading"><?php echo ucfirst($item->fach) ?> Kurs</h2>
                    <div class="angebote--item-status angebote--item-status-belegt"><?php echo ucfirst($item->status) ?></div>
                    <a href="/angeboteLehrerDetails?id=<?php echo "$item->id" ?>" class="angebote__item-button">Übersicht</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php } else { ?>
        <?php if(!empty($errorFach)){ ?>
            <a class="angebote__grid-filter" href="/angeboteOffen"><?php echo ucfirst($errorFach); ?> - Filter zurücksetzen</a>
        <?php } ?>
        <div class="angebote--grid" style="display: flex; align-items: center; justify-content: center; grid-column: 1 / 4">
            <h2 class="header--content-heading header__content-heading--center">Noch keine Angebote erstellt</h2>
        </div>
    <?php } ?>
</main>

<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<section id="angebotErstellenPopup" class="popup--hide popup__ontainer--medium">
    <div onclick="closePopupErstellen()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Neues Angebot <span class="popup__container-heading--to-small">Erstellen</span></h2>
    </div>
    <form method="post">
        <div class="popup__form-container">
            <p class="popup__form-label">Wähle das Fach deines Angebots</p>
            <div class="form__select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form__select-button form--select-button-radio">
                    <span class="form--select-value form--select-value-radio">Fach auswählen</span>
                    <span class="form__select-arrow"></span>
                </button>
                <ul class="form__select-list" role="listbox">
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="mathe" value="mathe" required="required">
                        <label for="mathe">Mathe</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="deutsch" value="deutsch">
                        <label for="deutsch">Deutsch</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="englisch" value="englisch">
                        <label for="englisch">Englisch</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="spanisch" value="spanisch">
                        <label for="spanisch">Spanisch</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="französisch" value="französisch">
                        <label for="französisch">Französisch</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="latein" value="latein">
                        <label for="latein">Latein</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="chemie" value="chemie">
                        <label for="chemie">Chemie</label>
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
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="dsp" value="dsp">
                        <label for="dsp">Darstellendes Spiel</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="geschichte" value="geschichte">
                        <label for="geschichte">Geschichte</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="politik" value="politik">
                        <label for="politik">Politik</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="erdkunde" value="erdkunde">
                        <label for="erdkunde">Erdkunde</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="religion" value="religion">
                        <label for="religion">Religion</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="werte-normen" value="werte-normen">
                        <label for="werte-normen">Werte & Normen</label>
                    </li>
                    <li class="form__select-option form--select-option-radio" role="option">
                        <input type="radio" name="fach" id="philosophie" value="philosophie">
                        <label for="philosophie">Philosophie</label>
                    </li>
                </ul>
            </div>
            <p class="popup__form-label popup__form-margin">Setze den Status deines Angebots</p>
            <div class="popup__form-radio-container">
                <div class="popup__form-radio-group">
                    <input type="radio" value="offen" name="angebot--status" id="angebot--status-offen" checked required="required">
                    <label class="popup__form-label" for="angebot--status-offen">Offen</label>
                </div>
                <div class="popup__form-radio-group">
                    <input type="radio" value="gebucht" name="angebot--status" id="angebot--status-geschlossen">
                    <label class="popup__form-label" for="angebot--status-geschlossen">Geschlossen</label>
                </div>
            </div>
            <p class="popup__form-label popup__form-margin">Lege die Jahrgangsstufe fest, an wen sich dein Angebot richtet:</p>
            <div class="form__select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form__select-button form--select-button-check">
                    <span class="form--select-value form--select-value-check">Jahrgänge ankreuzen</span>
                    <span class="form__select-arrow"></span>
                </button>
                <ul class="form__select-list" role="listbox">
                    <li class="form__select-option form--select-option-check" role="option">
                        <input type="checkbox" name="alter[]" id="fünf" value="5">
                        <label for="fünf">5.Klasse</label>
                    </li>
                    <li class="form__select-option form--select-option-check" role="option">
                        <input type="checkbox" name="alter[]" id="sechs" value="6">
                        <label for="sechs">6.Klasse</label>
                    </li>
                    <li class="form__select-option form--select-option-check" role="option">
                        <input type="checkbox" name="alter[]" id="sieben" value="7">
                        <label for="sieben">7.Klasse</label>
                    </li>
                    <li class="form__select-option form--select-option-check" role="option">
                        <input type="checkbox" name="alter[]" id="acht" value="8">
                        <label for="acht">8.Klasse</label>
                    </li>
                    <li class="form__select-option form--select-option-check" role="option">
                        <input type="checkbox" name="alter[]" id="neun" value="9">
                        <label for="neun">9.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="zehn" value="10">
                        <label for="zehn">10.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="elf" value="11">
                        <label for="elf">11.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="zwölf" value="12">
                        <label for="zwölf">12.Klasse</label>
                    </li>
                    <li class="form__select-option" role="option">
                        <input type="checkbox" name="alter[]" id="dreizehn" value="13">
                        <label for="dreizehn">13.Klasse</label>
                    </li>
                </ul>
            </div>
            <div class="profil__card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" name="submit" value="submit" class="button--submit">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Erstellen</p>
                </button>
                <button onclick="closePopupErstellen()" style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="button--reset__icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>

<section class="popup--hide popup__ontainer--medium popup__container--small popup--container-right filterPopup">
    <div onclick="closeFilterPopup()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Angebote filtern</h2>
    </div>
    <form method="post">
        <div class="popup__form-container" >
            <p class="popup__form-label">Wähle das Fach deines Angebots</p>
            <div class="form__select-container">
                <button type="button" role="combobox" aria-labelledby="select button" aria-haspopup="listbox" aria-expanded="false" aria-controls="select-dropdown" class="form__select-button form--select-button-filter">
                    <span class="form--select-value form--select-value-filter">Fach auswählen</span>
                    <span class="form__select-arrow"></span>
                </button>
                <ul class="form__select-list" role="listbox">
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="mathe-Filter" value="mathe">
                        <label for="mathe-Filter">Mathe</label>
                    </li>
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="deutsch-Filter" value="deutsch">
                        <label for="deutsch-Filter">Deutsch</label>
                    </li>
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="bio-Filter" value="bio">
                        <label for="bio-Filter">Bio</label>
                    </li>
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="physik-Filter" value="physik">
                        <label for="physik-Filter">Physik</label>
                    </li>
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="informatik-Filter" value="informatik">
                        <label for="informatik-Filter">Informatik</label>
                    </li>
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="kunst-Filter" value="kunst">
                        <label for="kunst-Filter">Kunst</label>
                    </li>
                    <li class="form__select-option form--select-option-filter" role="option">
                        <input type="radio" name="fachFilter" id="musik-Filter" value="musik">
                        <label for="musik-Filter">Musik</label>
                    </li>
                </ul>
            </div>
            <div class="profil__card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Filtern</p>
                </button>
                <button onclick="closeFilterPopup()" style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="button--reset__icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>

<section id="toggleView" class="popup--hide popup__ontainer--medium popup__container--small popup--container-right">
    <div onclick="closePopupToggle()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Ansicht wechseln</h2>
    </div>
    <form method="post" style="display: flex; flex-direction: row; align-items: center; justify-content: center">
        <div class="popup__sub-nav-container" >
            <button name="changeView" value="changeView" type="submit" class="nav--switch border--left">
                Schüler
            </button>
            <div class="nav--switch nav--switch-active border--right">
                Lehrer
            </div>
        </div>
    </form>
</section>


<div style="margin-top: 15rem; width: 100%">
    <?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
</div>

<div id="angebotLehrerOverlay" class="popup--hide popup__overlay"></div>
<?php require_once __DIR__ . "/../../../App/Base/logInfo.php"; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../../../../scripts/offer.js"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<?php require_once __DIR__ . "/../../../App/Base/logScripts.php"; ?>
</body>
</html>
