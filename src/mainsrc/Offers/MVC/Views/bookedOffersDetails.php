<?php
# Paramter in Variablen Speichern
$id = $_GET["id"];
$fach = $angebot["fach"];
$status = $angebot["status"];
$jahrgang = $angebot["jahrgang"];
$email = $angebot["email"];
$beschreibung = $angebot["beschreibung"];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Gebuchtes Angebot</title>
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Lehrer, meine Angebote, erstellt von mir, TeachGym">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
</head>
<body style="background-color: #F3F4F6">
<header>
    <nav style="background-color: #ffffff" class="nav">
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
        <div class="icon--button nav--notification" onclick="openLogPopup()" ><div class="icon--button-new <?php if(!empty($logDelivered)){ ?>icon--button-new-active<?php } ?>"></div><i class="fa-regular fa-bell"></i></div>
        <div class="icon--button icon--button-profil nav--profil"><i class="fa-regular fa-user"></i></div>
        <a href="/logout" class="nav--username">Logout</a>
    </nav>
    <div class="nav--sub">
        <div onclick="openPopupSubNavToggle()" style="text-decoration: none" class="nav--sub-action nav--sub-hide-more"><i style="margin-right: 0.2em" class="fa-regular fa-compass"></i> Navigation</div>
        <div onclick="backToOverview()" class="nav--sub-action nav--sub-hide"><i style="margin-right: 0.2em" class="fa-solid fa-arrow-rotate-left"></i> Zurück zur Übersicht</div>
        <div onclick="openPopupBeenden()" style="margin-left: 1rem" class="nav--sub-action nav--sub-hide"><i style="margin-right: 0.2em" class="fa-solid fa-trash"></i> Nachhilfe beenden</div>
    </div>
</header>
<main class="angebot--main" style="background-color: #F3F4F6">
    <div class="angebot--wrapper">
        <div class="<?php echo "$fach" . "-bg" ?> angebot--header">
            <div class="angebot--header-icon">
                <?php include __DIR__ . "/../../../Home/MVC/Views/Design/$fach.php"?>
            </div>
        </div>
        <div class="angebot--content">
            <h1 class="angebot--fach"><?php echo ucfirst($fach) ?> Kurs</h1>
            <div class="angebot--value"><span class="angebot--info">Status:</span> <?php echo ucfirst($status) ?></div>
            <div class="angebot--value"><span class="angebot--info">Für die Altersstufe:</span> <?php echo $jahrgang ?></div>
            <div onclick="openPopupBeenden()" class="angebot--link">Nachhilfe beenden</a>
        </div>
    </div>
</main>
<section class="angebot--teilnehmer">
    <h2 class="angebot--teilnehmer-heading">Übersicht </h2>
    <ul class="angebot--teilnehmer-subnav">
        <li class="angebot--teilnehmer-list-active angebot--teilnehmer-list">Kontaktdaten</li>
    </ul>
    <div class="angebot--contact-container angebot--contact-container-small">
        <p class="angebot--contact-explanation">
            <b>Email-Adresse des Lehrer:</b> <br><?php echo $logDescriptionMail->contentMail ?>
        </p>
        <p class="angebot--contact-explanation" >
            <b>Beschreibung des Lehrers:</b> <br><?php echo $logDescriptionMail->contentForm ?>
        </p>
    </div>
    <ul class="angebot--teilnehmer-subnav">
        <li class="angebot--teilnehmer-list-active angebot--teilnehmer-list">Aktionen</li>
    </ul>
    <div class="angebot--contact-container angebot--contact-container-small">
        <p class="angebot--contact-explanation">
            Du bist hier aktuell bei der Nachhilfe angemeldet. Du kannst sie hier jederzeit beenden.
        </p>
        <div class="angebot--teilnehmer-container">
            <button onclick="openPopupBeenden()" class="angebot--contact-edit">Nachhilfe beenden</button>
        </div>
    </div>
    <ul class="angebot--teilnehmer-subnav">
        <li class="angebot--teilnehmer-list-active angebot--teilnehmer-list">Profil vom Lehrer <?php echo ucfirst($lehrer->username) ?>:</li>
    </ul>
    <div class="angebot--contact-container" style="height: 50rem; ">
        <p class="angebot--contact-explanation">
            Hier kannst du das Profil deines Lehrers einsehen.
        </p>
        <div class="profil--card profil--card-detail-modifier">
            <div class="profil--card-header">
                <div class="profil--card-imageBox">
                    <?php if($lehrer->geschlecht == "männlich"){ ?>
                        <?php include __DIR__ . "/../../../Home/MVC/Views/Design/male.php"?>
                    <?php } else { ?>
                        <?php include __DIR__ . "/../../../Home/MVC/Views/Design/female.php"?>
                    <?php } ?>
                </div>
            </div>
            <div>
                <h1 class="profil--card-name"><?php echo ucfirst($lehrer->username) ?></h1>
                <p class="profil--card-geschlecht"><?php echo ucfirst($lehrer->geschlecht)?></p>
            </div>
            <div class="profil--card-form" >
                <div class="profil--card-form-group">
                    <p class="form--input-label-small">Name</p>
                    <p><?php echo ucfirst($lehrer->username); ?></p>
                </div>
                <div class="profil--card-form-group" style="margin-top: 1rem">
                    <p class="form--input-label-small">Geschlecht</p>
                    <p>
                    <?php
                    if($lehrer->geschlecht == "männlich"){
                        echo "Männlich";
                    } elseif($lehrer->geschlecht == "weiblich") {
                        echo "Weiblich";}
                    ?>
                    </p>
                </div>
                <div class="profil--card-form-group" style="margin-top: 1rem">
                    <p class="form--input-label-small">Klasse</p>
                    <p><?php echo $lehrer->stufe?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popups - Nachhilfe beenden -->
<section id="angebotBeendenPopup" class="popup--hide popup--container-small popup--container-medium">
    <div onclick="closePopupBeenden()" class="popup--container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup--container-header">
        <h2 class="popup--container-heading">Nachhilfe beenden</h2>
    </div>
    <form method="post">
        <div class="popup--form-container">
            <p class="popup--form-label">Möchtest du die Nachhilfe bei diesem Angebot wirklich beenden?</p>
            <div class="profil--card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit" name="nachhilfeBeenden" value="beenden">
                    <i class="btn-submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Beenden</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" onclick="closePopupBeenden()" class="button--reset">
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
        <div onclick="backToOverview()" class="nav--sub-action nav--sub-action-dark"><i style="margin-right: 0.2em" class="fa-solid fa-arrow-rotate-left"></i> Zurück zur Übersicht</div>
        <div onclick="closePopupSubNavToggle(); openPopupBeenden()" style="margin-left: 1rem" class="nav--sub-action nav--sub-action-dark"><i style="margin-right: 0.2em" class="fa-solid fa-trash"></i> Nachhilfe beenden</div>
    </div>
</section>


<div id="angebotLehrerOverlay" class="popup--hide popup--overlay"></div>

<?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
<div id="angebotOffenOverlay" class="popup--hide popup--overlay"></div>
<?php require_once __DIR__ . "/../../../App/Base/logInfo.php"; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<script src="../../../../scripts/bookedOfferDetailsListener.js"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<?php require_once __DIR__ . "/../../../App/Base/logScripts.php"; ?>
</body>
</html>


