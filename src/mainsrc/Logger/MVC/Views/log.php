<?php
$permission = $_SESSION["userPermission"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Cinnec">
    <meta name="keywords" content="Login, Login, TeachGym">
    <?php require_once __DIR__ . "/../../../App/Base/base.php"?>
    <?php if($permission == "teacher"){ ?>
        <link href="../../../../styles/darktheme.css" type="text/css" rel="stylesheet">
    <?php } ?>
    <title>Angebot Page</title>
</head>
<body>
<header>
    <nav class="nav">
        <h2 class="nav--heading">TeachGym</h2>
        <h2 class="nav--heading nav--heading-small">TG</h2>
        <div class="icon--button icon--button-log nav--notification" onclick="setHeaderLocation()" ><div class="icon--button-new <?php if(!empty($logDelivered)){ ?>icon--button-new-active<?php } ?>"></div><i class="fa-regular fa-bell"></i></div>
        <div class="icon--button icon--button-profil nav--profil" ><i class="fa-regular fa-user"></i></div>
        <a href="/logout" class="nav--username" >Logout</a>
    </nav>
</header>
<main>
    <h1 class="logger--heading">Benachrichtigungen</h1>
    <?php if(!empty($logDelivered) or !empty($logRead)){ ?>
        <?php if(!empty($logDelivered)){ ?>
    <h2 class="logger--sub-heading">Neue Benachrichtigungen (<?php echo count($logDelivered) ?>)</h2>
    <div class="logger--list">
        <?php foreach ($logDelivered as $item): ?>
            <?php if($item->category == "akzeptiert"){?>
                <div class="logger--container logger--container-delivered">
                    <p class="logger--text">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde akzeptiert. <a href="/angeboteGebuchtDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                    <form method="post">
                        <button name="notificationRead" value="<?php echo $item->id ?>" class="logger--button">Gelesen</button>
                    </form>
                </div>
            <?php } elseif($item->category == "abgelehnt"){?>
                <div class="logger--container logger--container-delivered">
                    <p class="logger--text">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde abgelehnt. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                    <form method="post">
                        <button name="notificationRead" value="<?php echo $item->id ?>" class="logger--button">Gelesen</button>
                    </form>
                </div>
            <?php } elseif($item->category == "beendet"){?>
                <div class="logger--container logger--container-delivered">
                    <p class="logger--text">Die Nachhilfe bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde beendet. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                    <form method="post">
                        <button name="notificationRead" value="<?php echo $item->id ?>" class="logger--button">Gelesen</button>
                    </form>
                </div>
            <?php } elseif($item->category == "angefragt"){?>
                <div class="logger--container logger--container-delivered">
                    <p class="logger--text"><?php echo $item->contentHeader ?> hat dein <?php echo ucfirst($item->contentBody) ?>-Angebot angefragt. <a href="/angeboteLehrerDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                    <form method="post">
                        <button name="notificationRead" value="<?php echo $item->id ?>" class="logger--button">Gelesen</button>
                    </form>
                </div>
            <?php } ?>
        <?php endforeach; ?>
    </div>
        <?php }?>
        <?php if (!empty($logRead)){ ?>
    <h2 class="logger--sub-heading">Alte Benachrichtigungen</h2>
    <div class="logger--list">
        <?php foreach ($logRead as $item): ?>
            <?php if($item->category == "akzeptiert"){?>
                <div class="logger--container logger--container-read">
                    <p class="logger--text">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde akzeptiert. <a href="/angeboteGebuchtDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                </div>
            <?php } elseif($item->category == "abgelehnt"){?>
                <div class="logger--container logger--container-read">
                    <p class="logger--text">Deine Anfrage bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde abgelehnt. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                </div>
            <?php } elseif($item->category == "beendet"){?>
                <div class="logger--container logger--container-read">
                    <p class="logger--text">Die Nachhilfe bei <?php echo $item->contentHeader ?> im <?php echo ucfirst($item->contentBody) ?>-Angebot wurde beendet. <a href="/angeboteOffenDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                </div>
            <?php } elseif($item->category == "angefragt"){?>
                <div class="logger--container logger--container-read">
                    <p class="logger--text"><?php echo $item->contentHeader ?> hat dein <?php echo ucfirst($item->contentBody) ?>-Angebot angefragt. <a href="/angeboteLehrerDetails?id=<?php echo $item->sender ?>" class="logger--link">Klicke für mehr Informationen.</a></p>
                </div>
            <?php } ?>
        <?php endforeach; ?>
    </div>
        <?php } ?>
    <?php } else { ?>
        <p class="logger--error">Du hast keine Benachrichtigungen.</p>
    <?php } ?>
</main>
<?php require_once __DIR__ . "/../../../App/Base/footer.php"; ?>
<script src="https://kit.fontawesome.com/a043dc9ebd.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../../../../scripts/linkEvents.js"></script>
<script>
    function setHeaderLocation(){
        window.location = "https://cinnec.de/logger";
    }
</script>
</body>
</html>