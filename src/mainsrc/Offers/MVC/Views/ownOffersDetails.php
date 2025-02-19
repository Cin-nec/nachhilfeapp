<?php
# Get Paramter in Variablen Speichern
$id = $_GET["id"];
$lehrer = $angebot["lehrer"];
$fach = $angebot["fach"];
$status = $angebot["status"];
$jahrgang = $angebot["jahrgang"];
$email = $angebot["email"];
$beschreibung = $angebot["beschreibung"];
$permission = $_SESSION["userPermission"];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Erstellte Angebote</title>
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Lehrer, meine Angebote, erstellt von mir, TeachGym">
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
        <div onclick="openPopupSubNavToggle()" style="text-decoration: none" class="nav__sub-action nav__sub--hide-more"><i style="margin-right: 0.2em" class="fa-regular fa-compass"></i> Navigation</div>
        <div onclick="backToOverview()" class="nav__sub-action nav__sub--hide"><i style="margin-right: 0.2em" class="fa-solid fa-arrow-rotate-left"></i> Zurück zur Übersicht</div>
        <div onclick="openPopupBearbeiten()" style="margin-left: 1rem" class="nav__sub-action nav__sub--hide"><i style="margin-right: 0.2em" class="fa-solid fa-pencil"></i> Angebot Bearbeiten</div>
        <div onclick="openPopupLoeschen()" style="margin-left: 1rem" class="nav__sub-action nav__sub--hide"><i style="margin-right: 0.2em" class="fa-solid fa-trash"></i> Angebot Löschen</div>
    </div>
</header>
<main class="angebot__main" style="<?php if($permission == "teacher"){ ?> background-color: #374151; <?php } else { ?>background-color: #F3F4F6<?php } ?>">
    <div class="angebot--wrapper">
        <div class="<?php echo ">
            <div class="angebot--header-icon">
                <?php include __DIR__ . "/../../../Home/MVC/Views/Design/$fach.php"?>
            </div>
        </div>
        <div class="angebot--content">
            <h1 class="angebot--fach"><?php echo ucfirst($fach) ?> Kurs</h1>
            <div class="angebot--value"><span class="angebot--info">Status:</span> <?php echo ucfirst($status) ?></div>
            <div class="angebot--value"><span class="angebot--info">Für die Altersstufen:</span> <?php echo ucfirst($jahrgang) ?></div>
            <div style="cursor: pointer" onclick="openPopupBearbeiten()" class="angebot--link">Bearbeite dein Angebot</div>
        </div>
    </div>
</main>
<section class="angebot--teilnehmer">
    <h2 class="angebot--teilnehmer-heading">Teilnehmer </h2>
    <ul class="angebot--teilnehmer-subnav angebot--teilnehmer-subnav-eigeneAngebote">
        <li id="aktiveTeilnehmer" class="angebot--teilnehmer-list-active angebot--teilnehmer-list angebot--teilnehmer-list-eigeneAngebote">Aktive Teilnehmer</li>
        <li id="ausstehendeAnfragen" class="angebot--teilnehmer-list angebot--teilnehmer-list-eigeneAngebote">Ausstehende Anfragen</li>
        <li id="kontaktFormular" class="angebot--teilnehmer-list angebot--teilnehmer-list-eigeneAngebote">Kontakt-Formular</li>
    </ul>
    <form method="post" class="angebot--eventContainer angebot--teilnehmer-container angebot--hide-first" >
        <?php if($gebuchteUser[0] == false && empty($gebuchteUser[1])){ echo '<p class="angebot--empty" style="margin-top: 3rem">Bisher nimmt noch niemand fest an dieser Nachhilfe teil</p>';} else { ?>
        <?php for ($i = 0; $i < count($gebuchteUser); $i++) { ?>
        <div class="angebot--teilnehmer-wrapper">
            <div class="angebot--teilnehmer-image">
                <?php if($gebuchteUser[$i]->geschlecht == "männlich"){ ?>
                    <?php include __DIR__ . "/../../../Home/MVC/Views/Design/malesmall.php"?>
                <?php } else { ?>
                    <?php include __DIR__ . "/../../../Home/MVC/Views/Design/femalesmall.php"?>
                <?php } ?>
            </div>
            <h2 class="angebot--teilnehmer-name"><?php echo ucfirst($gebuchteUser[$i]->username) ?></h2>
            <p class="angebot--teilnehmer-geschlecht"><?php echo ucfirst($gebuchteUser[$i]->geschlecht) ?></p>
            <p class="angebot--teilnehmer-class"><?php echo $gebuchteUser[$i]->stufe ?>. Klasse</p>
            <button type="submit" name="teilnehmerEntfernen" value="<?php echo $gebuchteUser[$i]->userid ?>" class="angebot__teilnehmer-delete">Teilnehmer entfernen</button>
            <button type="submit" name="teilnehmerEntfernen" value="<?php echo $gebuchteUser[$i]->userid ?>" class="angebot__teilnehmer-delete angebot__teilnehmer-delete--small">Entfernen</button>
            <button type="submit" name="teilnehmerEntfernen" value="<?php echo $gebuchteUser[$i]->userid ?>" class="angebot__teilnehmer-delete angebot__teilnehmer-delete--tiny"><i class="fa-solid fa-x"></i></button>
        </div>
        <?php } ?>
        <?php } ?>
    </form>
    <form method="post" class="angebot--eventContainer angebot__teilnehmer-container angebot__hide angebot--hide-second" >
        <?php if($userAnfragen[0] == false){ echo '<p class="angebot--empty" style="margin-top: 3rem">Du hast noch keine Anfragen</p>';} else { ?>
            <?php foreach ($userAnfragen as $item) : ?>
                <div class="angebot__teilnehmer-wrapper angebot__teilnehmer-wrapper--second">
                    <div class="angebot__teilnehmer-image angebot__teilnehmer-image--second">
                        <?php if($item->geschlecht == "männlich"){ ?>
                            <?php include __DIR__ . "/../../../Home/MVC/Views/Design/malesmall.php"?>
                        <?php } else { ?>
                            <?php include __DIR__ . "/../../../Home/MVC/Views/Design/femalesmall.php"?>
                        <?php } ?>
                    </div>
                    <h2 class="angebot__teilnehmer-name angebot__teilnehmer-name--second"><?php echo ucfirst($item->username) ?></h2>
                    <p class="angebot--teilnehmer-geschlecht angebot--teilnehmer-geschlecht-second"><?php echo ucfirst($item->geschlecht) ?></p>
                    <p class="angebot--teilnehmer-class angebot--teilnehmer-class-second"><?php echo $item->stufe ?>. Klasse</p>
                    <button type="submit" name="teilnehmerAnnehmen" value="<?php echo $item->userid ?>" class="angebot__anfragen-annehmen angebot__anfragen-annehmen--second">Annehmen</button>
                    <button type="submit" name="teilnehmerAblehnen" value="<?php echo $item->userid ?>" class="angebot__anfragen-ablehnen angebot__anfragen-ablehnen--second">Ablehnen</button>
                </div>
            <?php endforeach; ?>
        <?php } ?>
    </form>
    <div class="angebot--eventContainer angebot__contact-container angebot__hide angebot--hide-third ">
        <p class="angebot--contact-explanation">
            Dieses Kontakt Formular wird an Schüler gesendet, deren Anfrage bei diesem Nachhilfe-Angebot angenommen wurde.
            Versende ausschließlich benötigte Informationen für die Kontaktaufnahme!
        </p>
        <h2 class="angebot--contact-heading">E-Mail Adresse</h2>
        <div class="angebot__contact-wrapper"><?php if(!empty($email)){ echo $email;} else { echo '<p class="angebot--contact-email">Du hast noch keine Email-Adresse angegeben</p>';} ?></div>
        <h2 class="angebot--contact-heading">Kurze Beschreibung</h2>
        <div class="angebot__contact-wrapper-big"><?php if(!empty($beschreibung)){ echo $beschreibung;} else { echo "Du hast noch keine Beschreibung angegeben";} ?></div>
        <div class="angebot__width">
            <button onclick="openPopupKontakt()" class="angebot--contact-edit">Bearbeiten</button>
        </div>
    </div>
</section>


<!-- Section Popup um das Angebot zu bearbeiten -->
<section id="angebotBearbeitenPopup" class="popup--hide popup__ontainer--medium">
    <div onclick="closePopupBearbeiten()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Angebot bearbeiten</h2>
    </div>
    <form method="post" action="/angeboteLehrerDetails?id=<?php echo "$id" ?>">
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
                    <input required="required" type="radio" value="offen" name="status" id="angebot--status-offen" <?php if($status == "offen"){ echo 'checked';} ?>>
                    <label class="popup__form-label" for="angebot--status-offen">Offen</label>
                </div>
                <div class="popup__form-radio-group">
                    <input type="radio" value="gebucht" name="status" id="angebot--status-geschlossen" <?php if($status == "gebucht"){echo 'checked';} ?>>
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
                <button type="submit" name="submitChange" value="submit" class="button--submit">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Speichern</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="button--reset__icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>

<!-- Section Popup um das Angebot zu löschen -->
<section id="angebotLoeschenPopup" class="popup--hide popup__container--small popup__ontainer--medium">
    <div onclick="closePopupLoeschen()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Angebot löschen</h2>
    </div>
    <form method="post">
        <div class="popup__form-container">
            <p class="popup__form-label">Möchtest du dieses Angebot wirklich unwiderruflich löschen? Personen die aktuell bei der Nachhilfe angemeldet sind werden entfernt.</p>
            <div class="profil__card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit" name="deleteBefehl" value="delete">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Löschen</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" onclick="closePopupLoeschen()" class="button--reset">
                    <i class="button--reset__icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </div>
    </form>
</section>

<!-- Section Popup um das Kontaktformular zu bearbeiten -->
<section id="kontaktBearbeitenPopup" class="popup--hide popup__ontainer--medium">
    <div onclick="closePopupKontakt()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading popup__container-heading--hide">Kontakt Formular bearbeiten</h2>
        <h2 class="popup__container-heading popup__container-heading--five-hundred">Kontakt Formular </h2>
    </div>
    <form method="post">
        <div class="popup__form-container">
            <p class="popup__form-label">Gebe hier bspw. deine Email-Addresse an, unter der dich dein Schüler kontaktieren soll.</p>
            <input style="margin-top: 1rem" class="form__input--text" name="email" type="email" maxlength="64" placeholder="<?php if(!empty($email)){ echo $email;} else { echo "Email-Adresse";} ?>">
            <p style="margin-top: 1rem" class="popup__form-label">Gebe hier noch eine kurze sinnvolle Beschreibung an:</p>
            <textarea name="beschreibung" class="form__input--textarea" style="margin-top: 1rem" maxlength="300"><?php if(!empty($beschreibung)){ echo $beschreibung;} else { echo "Du hast noch keine Beschreibung angegeben";} ?></textarea>
            <div class="profil__card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Speichern</p>
                </button>
                <button onclick="closePopupKontakt()" name="submitKontakt" value="submit" style="margin-left: 0.5rem" type="reset" class="button--reset">
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

<section id="toggleSubNavView" class="popup--hide popup__ontainer--medium popup__container--small popup--container-right">
    <div onclick="closePopupSubNavToggle()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Navigieren</h2>
    </div>
    <div class="nav__sub-list">
        <div onclick="backToOverview()" class="nav__sub-action nav__sub-action--dark"><i style="margin-right: 0.2em" class="fa-solid fa-arrow-rotate-left"></i> Zurück zur Übersicht</div>
        <div onclick="openPopupBearbeiten()" style="margin-left: 1rem" class="nav__sub-action nav__sub-action--dark"><i style="margin-right: 0.2em" class="fa-solid fa-pencil"></i> Angebot Bearbeiten</div>
        <div onclick="openPopupLoeschen()" style="margin-left: 1rem" class="nav__sub-action nav__sub-action--dark"><i style="margin-right: 0.2em" class="fa-solid fa-trash"></i> Angebot Löschen</div>
    </div>
</section>

<div id="angebotLehrerOverlay" class="popup--hide popup__overlay"></div>

<?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
<?php require_once __DIR__ . "/../../../App/Base/logInfo.php"; ?>
<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../../../../scripts/ownOfferDetailsListener.js"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<?php require_once __DIR__ . "/../../../App/Base/logScripts.php"; ?>
</body>
</html>