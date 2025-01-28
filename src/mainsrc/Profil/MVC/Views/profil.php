<?php $permission = $_SESSION["userPermission"]; ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Profil, Dein Profil, TeachGym">
    <title>Profil Page</title>
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
    <?php if($permission == "teacher"){ ?>
        <link href="../../../../styles/darktheme.css" type="text/css" rel="stylesheet">
    <?php } ?>
</head>
<body style="<?php if($permission == "teacher"){ ?> background-color: #374151; <?php } else { ?>background-color: #F3F4F6<?php } ?>">
<header>
    <nav class="nav">
        <h2 class="nav--heading">TeachGym</h2>
        <h2 class="nav--heading nav--heading-small">TG</h2>
        <div class="icon--button nav--notification" onclick="openLogPopup()"><div class="icon--button-new <?php if(!empty($logDelivered)){ ?>icon--button-new-active<?php } ?>"></div><i class="fa-regular fa-bell"></i></div>
        <div class="icon--button icon--button-profil nav--profil"><i class="fa-regular fa-user"></i></div>
        <a href="/logout" class="nav--username">Logout</a>
    </nav>
</header>
<main class="profil--main">
    <div class="profil--card">
        <div class="profil--card-header">
            <div class="profil--card-imageBox">
                <?php if($_SESSION["geschlecht"] == "männlich"){ ?>
                    <?php include __DIR__ . "/../../../Home/MVC/Views/Design/male.php"?>
                <?php } else { ?>
                    <?php include __DIR__ . "/../../../Home/MVC/Views/Design/female.php"?>
                <?php } ?>
            </div>
        </div>
        <div>
            <h1 class="profil--card-name"><?php echo ucfirst($_SESSION["username"]) ?></h1>
            <p class="profil--card-geschlecht"><?php echo ucfirst($_SESSION['geschlecht'])?></p>
        </div>
        <form class="profil--card-form" method="post">
            <div class="profil--card-form-group">
                <label class="form--input-label-small" for="profilName">Name</label>
                <input style="margin-top: 0.2rem" name="username" class="form--input-text-small" id="profilName" type="text" value="<?php echo $_SESSION['username']; ?>" placeholder="<?php echo ucfirst($_SESSION['username']); ?>">
                <div class="form--error-container">
                    <p class="form--error"><?php if(!empty($fail["name"])){ echo $fail["name"]; }?></p>
                </div>
            </div>
            <div class="profil--card-form-group" style="margin-top: 1rem">
                <label class="form--input-label-small">Geschlecht</label>
                <label for="männlich" style="margin-top: 0.2rem;" class="profil--card-form-control">
                    <input type="radio" id="männlich" name="geschlecht" value="männlich" <?php if($_SESSION["geschlecht"] == "männlich"){ echo "checked";} ?>>
                    <label style="cursor: pointer" for="männlich">Männlich</label>
                </label>
                <label for="weiblich" style="margin-top: 0.2rem" class="profil--card-form-control">
                    <input type="radio" id="weiblich" name="geschlecht" value="weiblich" <?php if($_SESSION["geschlecht"] == "weiblich"){ echo "checked";} ?>>
                    <label style="cursor: pointer" for="weiblich">Weiblich</label>
                </label>
                <div class="form--error-container"><p class="form--error"><?php if(!empty($fail["geschlecht"])){ echo $fail["geschlecht"]; }?></p></div>
            </div>
            <div class="profil--card-form-group" style="margin-top: 1rem">
                <label class="form--input-label-small" for="profilKlasse">Klasse</label>
                <div style="display: flex; align-items: center">
                    <input class="form--input-range" id="profilKlasse" name="age" value="<?php echo $_SESSION['stufe']?>" type="range" min="5" max="13">
                    <div id="profilSliderValue" class="form--input-range-value">5</div>
                    <div class="form--error-container"><p class="form--error"><?php if(!empty($fail["age"])){ echo $fail["age"]; }?></p></div>
                </div>
            </div>
            <div class="profil--card-form-group profil--card-button-group" style="display: flex; flex-direction: row; margin-top: 2rem">
                <button type="submit" class="button--submit">
                    <i class="btn-submit-icon fa-regular fa-paper-plane"></i><p class="btn-submit-text">Speichern</p>
                </button>
                <button style="margin-left: 0.5rem" type="reset" class="button--reset">
                    <i class="btn-reset-icon fa-solid fa-x"></i><p class="btn-reset-text">Abbrechen</p>
                </button>
            </div>
        </form>
    </div>
    <div class="profil--card-more">
        <h2 class="profil--card-more-heading">Wichtiges</h2>
        <a class="profil--card-more-link" href="/angeboteGebucht">Gebuchte Angebote</a>
        <a class="profil--card-more-link" href="/angeboteLehrer">Angebote von mir</a>
        <a class="profil--card-more-link" href="/logger">Postfach</a>
    </div>
</main>
<div class="footer--profil">
    <?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
</div>
<div id="angebotLehrerOverlay" class="popup--hide popup--overlay"></div>
<?php require_once __DIR__ . "/../../../App/Base/logInfo.php"; ?>
<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="../../../../scripts/profil.js"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<?php require_once __DIR__ . "/../../../App/Base/logScripts.php"; ?>
</body>
</html>
