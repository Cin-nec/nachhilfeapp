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
    <title>Offenes Angebot</title>
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Lehrer, meine Angebote, erstellt von mir, TeachGym">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
</head>
<body style="background-color: #F3F4F6">
<header>
    <nav style="background-color: #ffffff" class="nav">
        <h2 class="nav__heading">TeachGym</h2>
        <h2 class="nav__heading nav__heading--small">TG</h2>
        <form method="post" class="nav__explore">
            <div class="nav__switch nav__switch--active border--left">
                Schüler
            </div>
            <button name="changeView" value="changeView" type="submit" class="nav__switch border--right">
                Lehrer
            </button>
        </form>
        <div class="icon__button nav__explore-toggle" onclick="openPopupToggle()"><i class="fa-solid fa-repeat"></i></div>
        <div class="icon__button nav__notification" onclick="openLogPopup()" ><div class="icon__button--new <?php if(!empty($logDelivered)){ ?>icon--button-new-active<?php } ?>"></div><i class="fa-regular fa-bell"></i></div>
        <div class="icon__button icon--button-profil nav__profil" ><i class="fa-regular fa-user"></i></div>
        <a href="/logout" class="nav__username">Logout</a>
    </nav>
    <div class="nav__sub">
        <div onclick="openPopupSubNavToggle()" style="text-decoration: none" class="nav__sub-action nav__sub--hide-more"><i style="margin-right: 0.2em" class="fa-regular fa-compass"></i> Navigation</div>
        <div onclick="backToOverview()" class="nav__sub-action nav__sub--hide"><i style="margin-right: 0.2em" class="fa-solid fa-arrow-rotate-left"></i> Zurück zur Übersicht</div>
        <div onclick="openPopupAnfragen()" style="margin-left: 1rem" class="nav__sub-action nav__sub--hide"><i style="margin-right: 0.2em" class="fa-regular fa-bookmark"></i> Nachhilfe anfragen</div>
    </div>
</header>
<main class="angebot__main" style="background-color: #F3F4F6">
    <div class="angebot__wrapper">
        <div class="<?php echo ">
            <div class="angebot__header-icon">
                <?php include __DIR__ . "/../../../Home/MVC/Views/Design/$fach.php"?>
            </div>
        </div>
        <div class="angebot__content">
            <h1 class="angebot__fach"><?php echo ucfirst($fach) ?> Kurs</h1>
            <div class="angebot__value"><span class="angebot__info">Status:</span> <?php echo ucfirst($status) ?></div>
            <div class="angebot__value"><span class="angebot__info">Für die Altersstufe:</span> <?php echo $jahrgang ?></div>
            <button onclick="openPopupAnfragen()" class="angebot__link">Nachhilfe anfragen</button style="border: ">
        </div>
    </div>
</main>
<section class="angebot__teilnehmer">
    <h2 class="angebot__teilnehmer-heading">Übersicht </h2>
    <ul class="angebot__teilnehmer-subnav">
        <li class="angebot__teilnehmer-list--active angebot__teilnehmer-list">Profil vom Lehrer <?php echo ucfirst($lehrer->username) ?>:</li>
    </ul>
    <div class="angebot__contact-container" style="height: 50rem; ">
        <p class="angebot__contact-explanation" style="text-align: center">
            Hier kannst du das Profil deines Lehrers einsehen.
        </p>
        <div class="profil__card profil__card--detail-modifier">
            <div class="profil__card-header">
                <div class="profil__card-imageBox">
                    <?php if($lehrer->geschlecht == "männlich"){ ?>
                        <?php include __DIR__ . "/../../../Home/MVC/Views/Design/male.php"?>
                    <?php } else { ?>
                        <?php include __DIR__ . "/../../../Home/MVC/Views/Design/female.php"?>
                    <?php } ?>
                </div>
            </div>
            <div>
                <h1 class="profil__card-name"><?php echo ucfirst($lehrer->username) ?></h1>
                <p class="profil__card-geschlecht"><?php echo ucfirst($lehrer->geschlecht)?></p>
            </div>
            <div class="profil__card-form" >
                <div class="profil__card-form-group">
                    <p class="form__input--label-small">Name</p>
                    <p><?php echo ucfirst($lehrer->username); ?></p>
                </div>
                <div class="profil__card-form-group" style="margin-top: 1rem">
                    <p class="form__input--label-small">Geschlecht</p>
                    <p>
                        <?php
                        if($lehrer->geschlecht == "männlich"){
                            echo "Männlich";
                        } elseif($lehrer->geschlecht == "weiblich") {
                            echo "Weiblich";}
                        ?>
                    </p>
                </div>
                <div class="profil__card-form-group" style="margin-top: 1rem">
                    <p class="form__input--label-small">Klasse</p>
                    <p><?php echo $lehrer->stufe?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Popups - Angebote anfragen -->
<section id="angebotAnfragenPopup" class="popup--hide popup__container--small popup__ontainer--medium">
    <div onclick="closePopupAnfragen()" class="popup__container-icon"><i class="fa-solid fa-x"></i></div>
    <div class="popup__container-header">
        <h2 class="popup__container-heading">Angebot Anfragen</h2>
    </div>
    <form method="post">
        <div class="popup__form-container">
            <p class="popup__form-label">Möchtest du dieses Angebot anfragen? Sollte der Lehrer deine Anfrage akzeptieren, wirst du hier die Kontaktdaten finden.</p>
            <div class="profil__card-form-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit" name="anfragenBefehl" value="anfragen">
                    <i class="button--submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Anfragen</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" onclick="closePopupAnfragen()" class="button--reset">
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
            <div class="nav__switch nav__switch--active border--left">
                Schüler
            </div>
            <button style="color: #F3F4F6" name="changeView" value="changeView" type="submit" class="nav__switch border--right">
                Lehrer
            </button>
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
        <div onclick="closePopupSubNavToggle(); openPopupAnfragen()" style="margin-left: 1rem" class="nav__sub-action nav__sub-action--dark"><i style="margin-right: 0.2em" class="fa-regular fa-bookmark"></i> Nachhilfe anfragen</div>
    </div>
</section>

<div id="angebotOffenOverlay" class="popup--hide popup__overlay"></div>

<div id="angebotLehrerOverlay" class="popup--hide popup__overlay"></div>

<?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
<?php require_once __DIR__ . "/../../../App/Base/logInfo.php"; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<script src="../../../../scripts/openOfferDetailsListener.js"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<?php require_once __DIR__ . "/../../../App/Base/logScripts.php"; ?>
</body>
</html>


