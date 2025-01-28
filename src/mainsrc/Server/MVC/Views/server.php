<?php
session_start();
if(!$_SESSION['logged_in']){
    header('Location: /error');
}
extract($_SESSION['userData']);


$avatar_url = "https://cdn.discordapp.com/avatars/$discord_id/$avatar.jpg";

if(is_bool($_SESSION["userData"]['guilds']['global']) ){
    header("Location: /server");
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Aromic4All - Dashboard</title>
    <meta name="keywords" content="Discord Bot, Homepage, Aromic4All, helpfull, Dc bot, bot, discord, bot, Aromic Bot, Aromic,">
    <meta name="author" content="Cinnec">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../mainsrc/dist/main.css">
    <link rel="stylesheet" type="text/css" href="../mainsrc/fonts/fontawesome-free-6.1.1-web/css/all.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php if($_GET["error"] == 'server_not_found'){ ?>
<div class="black-container black-container--show" id="error-black-popup"></div>
<div class="server__error-container" id="error-popup">
    <div class="server__error-popup">
        <div class="server__error-popup-header">
            <h2 class="server__error-popup-header--heading">Oops, an error has occurred</h2>
            <div class="server__error-popup-close" id="popup-close">
                <i class='bx bx-x'></i>
            </div>
        </div>
        <p class="server__error-popup-header--paragraph">It looks like, the Guild Id was not matching your Guild Id</p>
        <button id="popup-close-button" class="button button--popup">Close</button>
    </div>
</div>
<?php } ?>
<div class="db-navigation-selection" id="db-check-nav" style="display: none; height: 14rem">
    <ul class="db-navigation-selection__list">
        <a href="/main/" class="db-navigation-selection__list-item">
            <i class='bx bx-home-heart' ></i><p class="db-navigation-selection__list-item-link">Homepage</p>
        </a>
        <a href="/server" class="db-navigation-selection__list-item">
            <i class='bx bx-server'></i><p class="db-navigation-selection__list-item-link">My Servers</p>
        </a>
        <a href="" class="db-navigation-selection__list-item">
            <i class='bx bxl-discord' ></i><p class="db-navigation-selection__list-item-link">Discord</p>
        </a>
        <a href="/logout" class="db-navigation-selection__list-item">
            <i class='bx bx-log-out'></i><p class="db-navigation-selection__list-item-link">Log Out</p>
        </a>
    </ul>
</div>
<nav class="db-navigation">
    <div class="db-navigation__logo-container">
        <div class="db-navigation__logo"></div>
Aromic4All-Dashboard
    </div>
    <div class="db-navigation__user-container">
        <img class="db-navigation__user-logo" src="<?php echo $avatar_url?>">
        <span class="db-navigation__user-name"><?php echo $name ?></span>
</div>
    <label id="first-bar" class="db-icon-button">
        <button class="menu" id="first-bar" onclick="this.classList.toggle('opened');this.setAttribute('aria-expanded', this.classList.contains('opened'));">
            <svg width="30" height="30" viewBox="0 0 100 100" style="color:white">
                <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
                <path class="line line2" d="M 20,50 H 80" />
                <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
            </svg>
        </button>
    </label>
</nav>
<section class="db-welcome">
    <div class="db-welcome-container">
        <div class="db-welcome__box db-welcome__box--1">
            <h2 class="db-welcome__subheading">How to start?</h2>
            <p class="db-welcome__paragraph">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem  </p>
            <p class="db-welcome__paragraph db-welcome__paragraph--2">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Loremm Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem </p>
            <p class="db-welcome__paragraph db-welcome__paragraph--2">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lore</p>
        </div>
        <div class="db-welcome__box db-welcome__box--2">
            <h2 class="db-welcome__subheading">Lorem Ipsum Lorem Ipsum</h2>
            <a href="https://top.gg/bot/996564216150495283">
                <img src="https://top.gg/api/widget/996564216150495283.svg">
            </a>
            <p class="db-welcome__paragraph db-welcome__paragraph--2">Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem Lorem Ipsum Lore</p>
        </div>
    </div>
</section>
<section class="db-server">
    <h2 class="db-server__heading">Lorem Ipsum Lorem Ipsum</h2>
    <div class="db-server__grid">
    <?php foreach ($guilds AS $guild):?>
    <?php $guild_icon = $guild["icon"];  $guild_id = $guild["id"]; $guild_permission = $guild["permissions"]; $generalAdmin = ($guild_permission & 0x8) != 0; $generalMangeServer = ($guild_permission & 0x20) != 0?>
        <?php if($generalAdmin == true or $generalMangeServer == true){ ?>
        <div class="db-server__container">
            <?php $headers = get_headers("https://cdn.discordapp.com/icons/$guild_id/$guild_icon.png", 1); if($headers[0] == 'HTTP/1.1 404 Not Found'){ ?>
            <div class="db-server__image-fail"><?php echo $guild["name"][0] ?></div>
                <div class="db-server__container-logo"></div>
            <?php } else { ?>
                <div class="db-server__image-fail"></div>
            <img src="<?php echo "https://cdn.discordapp.com/icons/$guild_id/$guild_icon.png"; ?>" alt="." class="db-server__container-logo">
            <?php } ?>
            <div class="db-server__container-text">
                <h3 class="db-server__container-text__heading"><?php echo substr($guild["name"], 0 , 25) ?></h3>
            </div>
            <?php if(in_array($guild_id, $guildIDs)){ ?>
                    <?php if(!in_array($guild["id"], $_SESSION["allowedIDs"])){
                    $_SESSION["allowedIDs"][] = $guild["id"];
                }
                ?>
            <a href="/dashboard=guild?guildid=<?php echo $guild["id"]?>&guildname=<?php echo $guild["name"]?>" class="button button--edit">Edit</a>
            <?php } else { ?>
                <a href="<?php echo "https://discord.com/api/oauth2/authorize?client_id=996564216150495283&permissions=1945627743&scope=bot%20applications.commands&guild_id=$guild_id"?>" class="button button--invite">Invite</a>
            <?php }; ?>
        </div>
        <?php }; ?>
    <?php endforeach;#?>
    </div>
</section>
<footer class="footer">
    <h2 class="footer__heading">Aromic4All</h2>
    <ul class="footer__list">
        <li><a class="footer__list-item" href="#">Terms</a></li>
        <li><a class="footer__list-item" href="#">License</a></li>
        <li><a class="footer__list-item" href="#">Privacy</a></li>
    </ul>
    <div class="footer__icons">
        <a style="text-decoration: none" href="https://discord.gg/9WQKRGGvAH" class="footer__item fa-brands fa-discord"></a>
        <a style="text-decoration: none" href="https://instagram.com/JerbyYT" class="footer__item fa-brands fa-instagram"></a>
        <a style="text-decoration: none" href="https://youtube.com/JerbyYT" class="footer__item fa-brands fa-youtube"></a>
    </div>
    <ul class="footer__quellen">
        <li><a class="footer__quellen-item" href="https://de.freepik.com/vektoren/illustration">Illustration Vektor erstellt von upklyak - de.freepik.com</a></li>
        <li><a class="footer__quellen-item" href='https://de.freepik.com/vektoren/startup'>Startup Vektor erstellt von storyset - de.freepik.com</a></li>
    </ul>
    <p class="footer__copyright">	&copy - Aromic4All</p>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="../mainsrc/Scripts/events.js"></script>
</body>
</html>